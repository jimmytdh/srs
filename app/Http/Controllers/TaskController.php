<?php

namespace App\Http\Controllers;

use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function index()
    {
        $task = Task::select('*');
        $search = Session::get('searchTask');

        if ($search['keyword']) {
            $keyword = $search['keyword'];
            $task = $task->where('description', 'like', "%$keyword%");
        }

        if ($search['assign_to']) {
            $task = $task->where('assign_to', $search['assign_to']);
        }

        if ($search['status']) {
            $task = $task->where('status', $search['status']);
        }

        if ($search['date_range']) {
            $string = explode('-', $search['date_range']);

            $date1 = date('Y-m-d', strtotime($string[0]));
            $date2 = date('Y-m-d', strtotime($string[1]));

            $start = Carbon::parse($date1)->startOfDay();
            $end = Carbon::parse($date2)->endOfDay();

            $data = $task->whereBetween('due_date', [$start, $end]);
        }

        $data = $task->orderBy('status', 'desc')
            ->orderBy('due_date', 'asc')
            ->paginate(20);

        return view('page.task', [
            'data' => $data,
            'menu' => 'task'
        ]);
    }

    public function search(Request $req)
    {
        $search = array(
            'keyword' => $req->keyword,
            'assign_to' => $req->assign_to,
            'status' => $req->status,
            'date_range' => $req->date_range
        );
        Session::put('searchTask', $search);
        return redirect('/tasks');
    }

    public function store(Request $request)
    {
        $data = array(
            'due_date' => $request->due_date,
            'description' => $request->description,
            'assign_to' => $request->assign_to,
            'status' => 'Pending',
            'remarks' => $request->remarks
        );
        Task::create($data);
        return redirect()->back()->with('success', 'Successfully added');
    }

    public function edit($id)
    {
        $info = Task::find($id);
        return view('load.editTask', [
            'info' => $info
        ]);
    }

    public function update(Request $request, $id)
    {
        Task::find($id)
            ->update([
                'due_date' => $request->due_date,
                'description' => $request->description,
                'assign_to' => $request->assign_to,
                'status' => $request->status,
                'remarks' => $request->remarks
            ]);
        return redirect()->back()->with('success', 'Successfully updated');
    }

    public function destroy(Request $request)
    {
        Task::find($request->id)->delete();
        return redirect()->back()->with('success', 'Successfully deleted');
    }

    static function countPendingTask()
    {
        return Task::where('status','Pending')->count();
    }
}
