<?php

namespace App\Http\Controllers;

use App\Section;
use App\Tracking;
use App\TrackingMaster;
use App\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ParamController extends Controller
{
    static function getAge($dob)
    {
        $now = Carbon::now();
        $dob = Carbon::parse($dob);
        $age = $dob->diffInYears($now);

        return $age;
    }

    static function generateRouteNo()
    {
        $user = Session::get('user');
        $section = $user->section;

        $year = date('y');
        $month = date('m');
        $count = TrackingMaster::where('section',$section)
                    ->whereBetween('prepared_date',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])
                    ->count();
        $count++;
        $count = str_pad($count,3,0,STR_PAD_LEFT);

        $code = Section::find($user->section)->initial;

        return "$code-$year$month-$count";
    }

    static function getNextDate($id,$track_id)
    {
        $data = Tracking::where('id','>',$id)
            ->where('track_id',$track_id)
            ->first();
        if($data)
            return $data->date_in;

        return Carbon::now();
    }

    static function timeDiff($start,$end)
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);

        if($start > $end)
            return false;

        $start_time = strtotime($start);
        $end_time = strtotime($end);
        $difference = $end_time - $start_time;
        $diff = '';

        $seconds = $difference % 60;            //seconds
        $difference = floor($difference / 60);

        if($seconds) $diff = $seconds."sec";

        $min = $difference % 60;              // min
        $difference = floor($difference / 60);

        if($min) $diff = $min."min $diff";

        $hours = $difference % 24;  //hours
        $difference = floor($difference / 24);

        if($hours) $diff = $hours."hr $diff";

        $days = $difference % 30;  //days
        $difference = floor($difference / 30);

        if($days) $diff = $days."day $diff";

        $month = $difference % 12;  //month
        $difference = floor($difference / 12);

        if($month) $diff = $month."mo $diff";


        return $diff;
    }

    public function clearSession($session)
    {
        Session::forget($session);
        return redirect()->back();
    }

    static function string_limit_words($string, $word_limit) {
        $words = explode(' ', $string);
        $limit = implode(' ', array_slice($words, 0, $word_limit));
        if(strlen($string) > $word_limit){
            $limit = "$limit...";
        }

        return $limit;
    }

    public function loading()
    {
        return view('page.loading');
    }

    public function manual()
    {
        $fromDate = '2020-01-01';
        $toDate = '2020-12-31';

        $startDate = Carbon::parse($fromDate)->next(Carbon::FRIDAY); // Get the first friday.
        $endDate = Carbon::parse($toDate);

        $items = [4,3,2];

        for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
            $d = $date->format('Y-m-d');
            $code = $date->format('ymdHis');
            foreach($items as $id)
            {
                 $data = array(
                    'code' => $code,
                    'item_id' => $id,
                    'date_start' => Carbon::parse("$d 13:00:00"),
                    'date_end' => Carbon::parse("$d 17:00:00"),
                    'time_start' => Carbon::parse("13:00:00"),
                    'time_end' => Carbon::parse("17:00:00"),
                    'user' => 'Celine',
                    'title' => 'Nursing Service Meetings/Activities',
                    'description' => '4th Floor Conference Room',
                    'status' => 'Reserved'
                );
                Reservation::create($data);
            }
        }
   

        
        
    }
}
