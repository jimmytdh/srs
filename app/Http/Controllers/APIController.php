<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function fetchJobs()
    {
        $jobs = Job::where('status','Pending')
                    ->orderBy('request_date','desc')
                    ->get();
        $json = array();
        foreach($jobs as $j){
            $json['jobs'][] = array(
                'date_requested' => date('M d, Y h:i A',strtotime($j->request_date)),
                'requested_by' => $j->request_by,
                'office' => $j->request_office
            );
        }

        return $json;
    }
}
