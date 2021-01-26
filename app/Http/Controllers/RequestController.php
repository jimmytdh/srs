<?php

namespace App\Http\Controllers;

use App\Job;
use App\JobService;
use App\Services;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use FCMAPP;

class RequestController extends Controller
{
    public function jobRequest(Request $req)
    {
        $services = Services::get();
        if ($req->isMethod('post'))
        {
            $date = Carbon::parse("$req->requested_date $req->requested_time");
            $data = array(
                'request_date' => $date->format('Y-m-d H:i:s'),
                'request_by' => $req->request_by,
                'request_office' => $req->request_office,
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
            return 'Success';
        }
        return view('request',compact('services'));
    }
    public function generateFormNo($date)
    {
        $start = Carbon::parse($date)->startOfMonth();
        $end = Carbon::parse($date)->endOfMonth();

        $count = Job::whereBetween('request_date',[$start,$end])->count();
        return $count++;
    }

    function sendNotification(){
        $data = array(
            'title' => 'title',
            'body' => 'body'
        );
        FcmController::sendTo('Sample','New body here',null,$data);
        echo 'sent';
    }

}
