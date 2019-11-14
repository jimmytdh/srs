<?php

namespace App\Http\Controllers\admin;

use App\Division;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class DivisionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $data = self::getData();

        return view('admin.division',[
            'title' => 'List of Divisions',
            'data' => $data,
            'menu' => 'division'
        ]);
    }

    public function getData()
    {
        $keyword = Session::get('search_division');
        $data = Division::orderBy('code','asc');
        if($keyword){
            $data = $data->where('code','like',"%$keyword%")
                ->orwhere('description','like',"%$keyword%");
        }
        $data = $data->paginate(30);
        return $data;
    }

    public function save(Request $req)
    {
        Division::create([
            'code' => $req->code,
            'description' => $req->description
        ]);

        return redirect()->back()->with('status',[
            'title' => 'Success',
            'msg' => $req->description." successfully saved!",
            'status' => 'success'
        ]);
    }

    static function countUser($id)
    {
        $count = User::leftJoin('section','user.section','=','section.id')
                    ->leftJoin('division','section.division_id','=','division.id')
                    ->where('division.id',$id)
                    ->count();
        return $count;
    }

    public function edit($id)
    {
        $data = self::getData();
        $info = Division::find($id);
        if(!$info){
            return redirect('/admin/division')->with('status',[
                'title' => 'Access Denied',
                'msg' => "You have no access in this section!",
                'status' => 'error'
            ]);
        }


        return view('admin.division',[
            'title' => $info->description,
            'data' => $data,
            'info' => $info,
            'menu' => 'division',
            'edit' => true
        ]);
    }

    public function update(Request $req, $id)
    {
        Division::find($id)
            ->update([
                'code' => $req->code,
                'description' => $req->description
            ]);

        return redirect()->back()->with('status',[
            'title' => 'Success',
            'msg' => $req->description." successfully updated!",
            'status' => 'success'
        ]);
    }

    public function delete($id)
    {
        Division::find($id)->delete();
        return redirect('admin/division')->with('status',[
            'title' => 'Success',
            'msg' => "Successfully deleted!",
            'status' => 'info'
        ]);
    }

    public function search(Request $req)
    {
        Session::put('search_division',$req->keyword);
        return redirect()->back();
    }
}
