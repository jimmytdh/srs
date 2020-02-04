<?php

namespace App\Http\Controllers;

use App\Job;
use App\JobService;
use App\Services;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function index()
    {
        $keyword = \Illuminate\Support\Facades\Session::get('searchJob');
        $data = Job::select('*');
        if($keyword){
            $data = $data->where(function($q) use ($keyword){
                $q->where('request_office','like',"%$keyword%")
                    ->orwhere('remarks','like',"%$keyword%")
                    ->orwhere('service_by','like',"%$keyword%")
                    ->orwhere('request_by','like',"%$keyword%");
            });
        }

        $data = $data
            ->orderBy('id','desc')
            ->paginate(30);

        $services = Services::get();
        return view('page.job',[
            'menu' => 'job',
            'data' => $data,
            'services' => $services
        ]);
    }

    public function search(Request $req)
    {
        Session::put('searchJob',$req->keyword);
        return redirect()->back();
    }

    public function save(Request $req)
    {
        $date = Carbon::parse("$req->requested_date $req->requested_time");

        $data = array(
            'request_date' => $date->format('Y-m-d H:i:s'),
            'request_by' => $req->requested_by,
            'request_office' => $req->office,
            'others' => $req->others,
            'status' => 'Pending'
        );
        $job = Job::create($data);
        $last_id = $job->id;
        $code = self::generateFormNo($date);
        Job::find($last_id)
            ->update([
               'form_no' =>  $date->format('ym').'-'.str_pad($code,3,0,STR_PAD_LEFT)
            ]);
        $ids = $req->ids;
        if($ids)
        {
            foreach($ids as $id)
            {
                $tmp = array(
                    'job_id' => $last_id,
                    'service_id' => $id
                );
                JobService::create($tmp);
            }
        }

        return redirect('/job')->with('status',[
            'status' => 'success',
            'title' => 'Added',
            'msg' => $req->requested_by.' request successfully added!'
        ]);
    }

    public function generateFormNo($date)
    {
        $start = Carbon::parse($date)->startOfMonth();
        $end = Carbon::parse($date)->endOfMonth();

        $count = Job::whereBetween('request_date',[$start,$end])->count();
        return $count++;
    }

    public function edit($id)
    {
        $data = Job::find($id);
        $services = Services::get();
        return view('load.editJob',[
            'id' => $id,
            'data' => $data,
            'services' => $services
        ]);
    }

    static function ifService($job_id,$service_id)
    {
        $check = JobService::where('job_id',$job_id)
                ->where('service_id',$service_id)
                ->first();
        if($check)
            return true;
        return false;
    }

    public function update(Request $req, $id)
    {
        $date = Carbon::parse("$req->requested_date $req->requested_time");
        $data = array(
            'request_date' => $date->format('Y-m-d H:i:s'),
            'request_by' => $req->requested_by,
            'request_office' => $req->office,
            'others' => $req->others
        );

        Job::find($id)->update($data);

        JobService::where('job_id',$id)->delete();
        $ids = $req->ids;

        if($ids)
        {
            foreach($ids as $i)
            {
                $tmp = array(
                    'job_id' => $id,
                    'service_id' => $i
                );
                JobService::create($tmp);
            }
        }

        return redirect('/job')->with('status',[
            'status' => 'success',
            'title' => 'Added',
            'msg' => $req->requested_by.' request successfully updated!'
        ]);
    }

    public function delete(Request $req)
    {
        Job::find($req->id)->delete();

        return redirect()->back()->with('status',[
            'title' => 'Success',
            'msg' => 'Job request successfully deleted',
            'status' => 'success'
        ]);
    }

    public function editServices($id)
    {
        $data = Job::find($id);
        return view('load.editServices',[
            'data' => $data,
            'id' => $id
        ]);
    }

    public function updateServices(Request $req, $id)
    {
        $data = array(
            'findings' => $req->findings,
            'remarks' => $req->remarks,
            'service_by' => $req->service_by,
            'acted_date' => "$req->acted_date $req->acted_time",
            'completed_date' => "$req->completed_date $req->completed_time",
            'status' => 'Completed',
        );

        Job::find($id)
            ->update($data);

        return redirect('/job')->with('status',[
            'status' => 'success',
            'title' => 'Added',
            'msg' => $req->service_by.' successfully completed the job!'
        ]);
    }
}
