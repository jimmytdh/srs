<?php

namespace App\Http\Controllers;

use App\Borrow;
use App\Item;
use App\Job;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function index()
    {
        $user = Auth::user();
        return view('page.home',[
            'title' => 'Service Request Dashboard',
            'menu' => 'home',
            'countAll' => self::countAll(),
            'countReserved' => self::countReserved(),
            'countJobRequest' => self::countJobRequest(),
            'countSystemRequest' => self::countSystemRequest()
        ]);
    }

    public function countAll()
    {
        $count = Item::select('id')->count();
        return $count;
    }

    public function countReserved()
    {
        $date = date('Y-m-d');
        $count = DB::table('reservations')
            ->whereRaw('"'.$date.'" between `date_start` and `date_end`')
            ->groupBy('code')
            ->get();

        return count($count);
    }

    public function countJobRequest()
    {
        return 0;
    }

    public function countSystemRequest()
    {
        return 0;
    }


    public function lineChart()
    {
        $data = array();
        $date = Carbon::now()->addDay(-6)->format('M d, Y');

        for($i=0; $i<7; $i++)
        {
            $tmp_day = Carbon::parse($date)->format('M d');
            $data[] = array(
                'day' => $tmp_day,
                'job' =>  self::countJob($date),
                'task' =>  self::countTask($date)
            );
            $date = Carbon::parse($date)->addDay(1)->format('M d, Y');
        }

        return $data;
    }

    public function countJob($date)
    {
        $start = Carbon::parse($date)->startOfDay();
        $end = Carbon::parse($date)->endOfDay();
        $count = Job::whereBetween('request_date',[$start,$end]);

        return $count->count();
    }

    public function countTask($date)
    {
        $start = Carbon::parse($date)->startOfDay();
        $end = Carbon::parse($date)->endOfDay();
        $count = Task::whereBetween('created_at',[$start,$end]);

        return $count->count();
    }
}
