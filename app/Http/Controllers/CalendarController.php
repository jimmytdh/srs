<?php

namespace App\Http\Controllers;

use App\Events;
use App\Colors;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function index()
    {
        return view('user.calendar',[
            'title' => 'My Calendar',
            'menu' => 'calendar'
        ]);
    }

    public function save(Request $req)
    {
        $str = $req->daterange;
        $temp1 = explode('-',$str);
        $temp2 = array_slice($temp1, 0, 1);
        $tmp = implode(',', $temp2);
        $start_date = date('Y-m-d H:i:s',strtotime($tmp));

        $temp3 = array_slice($temp1, 1, 1);
        $tmp = implode(',', $temp3);
        $end_date = date('Y-m-d H:i:s',strtotime($tmp));
        $color = 'blue';
        if($req->repeat_every=='monthly'){
            $color = 'green';
        }else if($req->repeat_every=='annual'){
            $color = 'red';
        }
        $user = Session::get('user');
        $data = array(
            'title' => $req->title,
            'description' => $req->description,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'color' => $color,
            'repeat_every' => $req->repeat_every,
            'type' => 'personal',
            'username' => $user->username
        );
        Events::create($data);

        return redirect()->back()->with('status',[
            'title' => 'Success',
            'msg' => "$req->title successfully added to your calendar!",
            'status' => 'success'
        ]);
    }

    public function update(Request $req,$id)
    {
        $str = $req->daterange;
        $temp1 = explode('-',$str);
        $temp2 = array_slice($temp1, 0, 1);
        $tmp = implode(',', $temp2);
        $start_date = date('Y-m-d H:i:s',strtotime($tmp));

        $temp3 = array_slice($temp1, 1, 1);
        $tmp = implode(',', $temp3);
        $end_date = date('Y-m-d H:i:s',strtotime($tmp));
        $color = 'blue';
        if($req->repeat_every=='monthly'){
            $color = 'green';
        }else if($req->repeat_every=='annual'){
            $color = 'red';
        }

        $data = array(
            'title' => $req->title,
            'description' => $req->description,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'color' => $color,
            'repeat_every' => $req->repeat_every
        );
        Events::find($id)->update($data);

        return redirect()->back()->with('status',[
            'title' => 'Updated',
            'msg' => "$req->title successfully updated!",
            'status' => 'success'
        ]);
    }

    public function edit($id)
    {
        $user = Session::get('user');
        $event = Events::find($id);
        if(!$event || ($event->username != $user->username))
        {
            return redirect('/user/calendar')->with('status',[
                'title' => 'Access Denied',
                'msg' => "You have no access to edit this event!",
                'status' => 'error'
            ]);
        }

        return view('user.calendar',[
            'title' => $event->title,
            'menu' => 'calendar',
            'info' => $event,
            'edit' => true
        ]);
    }

    public function delete($id)
    {
        Events::find($id)->delete();
        return redirect('user/calendar')->with('status',[
            'title' => 'Success',
            'msg' => "Successfully deleted!",
            'status' => 'info'
        ]);
    }

    public function events()
    {
        $user = Session::get('user');

        $events = Events::where(function ($q) use($user) {
                $q->where('username',$user->username)
                    ->orwhere('type','all');
            })
            ->where(function($q){
                $q->whereBetween('start_date',[Carbon::now()->startOfYear(),Carbon::now()->endOfYear()])
                    ->orwhere('repeat_every','annual');
            })
            ->get();
        $result = array();
        foreach($events as $e)
        {
            $time = date('h:ia',strtotime($e->start_date))." to ".date('h:ia',strtotime($e->end_date));
            if($e->repeat_every=='monthly'){
                $m = Carbon::parse($e->start_date)->format('m');
                $m = 12 - $m;

                for($i=0;$i<=$m;$i++){
                    $date = Carbon::parse($e->start_date)->addMonth($i);

                    $time = Carbon::parse($e->end_date)->format('H:i:s');
                    $end_date = Carbon::parse($date)->format('Y-m-d')." ".$time;

                    if($date <= Carbon::parse($e->end_date)){
                        $start_date = Carbon::parse($date)->format("Y-m-d H:i:s");
                        $result[] = array(
                            'title' => $e->title,
                            'description' => "[$time] ".$e->description,
                            'end' => $end_date,
                            'start' => $start_date,
                            'backgroundColor' => self::colors($e->color),
                            'borderColor' => self::colors($e->color)
                        );
                    }
                }
            }else if($e->repeat_every=='annual'){
                $year = date('Y');
                $month = Carbon::parse($e->start_date)->format('m-d H:i:s');
                $date = "$year-$month";
                $time = Carbon::parse($e->end_date)->format('H:i:s');
                $end_date = Carbon::parse($date)->format('Y-m-d')." ".$time;
                $result[] = array(
                    'title' => $e->title,
                    'description' => "[$time] ".$e->description,
                    'start' => $date,
                    'end' => $end_date,
                    'backgroundColor' => self::colors($e->color),
                    'borderColor' => self::colors($e->color)
                );
            }else{
                $result[] = array(
                    'title' => $e->title,
                    'description' => "[$time] ".$e->description,
                    'start' => Carbon::parse($e->start_date)->format('Y-m-d H:i:s'),
                    'end' => Carbon::parse($e->end_date)->format('Y-m-d H:i:s'),
                    'backgroundColor' => self::colors($e->color),
                    'borderColor' => self::colors($e->color)
                );
            }
        }
        array_merge($result,self::birthday());
        $result = array_merge($result,self::birthday());
        return $result;
    }

    public function myCalendar()
    {
        $user = Session::get('user');

        $events = Events::where('username',$user->username)
                ->where(function($q){
                    $q->whereBetween('start_date',[Carbon::now()->startOfYear(),Carbon::now()->endOfYear()])
                        ->orwhere('repeat_every','annual');
                })
                ->get();
        $result = array();
        foreach($events as $e)
        {
            $time = date('h:ia',strtotime($e->start_date))." to ".date('h:ia',strtotime($e->end_date));
            if($e->repeat_every=='monthly'){
                $m = Carbon::parse($e->start_date)->format('m');
                $m = 12 - $m;

                for($i=0;$i<=$m;$i++){
                    $date = Carbon::parse($e->start_date)->addMonth($i);

                    if($date <= Carbon::parse($e->end_date)){
                        $start_date = Carbon::parse($date)->format("Y-m-d H:i:s");
                        $time = Carbon::parse($e->end_date)->format('H:i:s');
                        $end_date = Carbon::parse($start_date)->format('Y-m-d');
                        $result[] = array(
                            'title' => $e->title,
                            'description' => "[$time] ".$e->description,
                            'start' => $start_date,
                            'end' => $end_date." ".$time,
                            'url' => url('user/calendar/edit/'.$e->id),
                            'backgroundColor' => self::colors($e->color),
                            'borderColor' => self::colors($e->color)
                        );
                    }
                }
            }else if($e->repeat_every=='annual'){
                $year = date('Y');
                $month = Carbon::parse($e->start_date)->format('m-d H:i:s');
                $date = "$year-$month";

                $time = Carbon::parse($e->end_date)->format('H:i:s');
                $end_date = Carbon::parse($date)->format('Y-m-d')." ".$time;
                $result[] = array(
                    'title' => $e->title,
                    'description' => "[$time] ".$e->description,
                    'start' => $date,
                    'end' => $end_date,
                    'url' => url('user/calendar/edit/'.$e->id),
                    'allDay' => ($e->all_day==1) ? 'true':'false',
                    'backgroundColor' => self::colors($e->color),
                    'borderColor' => self::colors($e->color)
                );
            }else{
                $result[] = array(
                    'title' => $e->title,
                    'description' => "[$time] ".$e->description,
                    'start' => Carbon::parse($e->start_date)->format('Y-m-d H:i:s'),
                    'end' => Carbon::parse($e->end_date)->format('Y-m-d H:i:s'),
                    'allDay' => ($e->all_day==1) ? 'true':'false',
                    'url' => url('user/calendar/edit/'.$e->id),
                    'backgroundColor' => self::colors($e->color),
                    'borderColor' => self::colors($e->color)
                );
            }
        }

        return $result;
    }

    public function colors($color)
    {
        return Colors::where('color',$color)
            ->first()
            ->code;
    }

    public function birthday()
    {
        $user = User::get();
        $result = array();
        foreach($user as $u){
            $year = date('Y');
            $month = Carbon::parse($u->dob)->format('m-d H:i:s');
            $date = "$year-$month";
            $result[] = array(
                'title' => $u->fname." ".$u->lname." birthday",
                'description' => $u->fname." ".$u->lname." Birthday",
                'start' => $date,
                'allDay' => true,
                'backgroundColor' => self::colors('red'),
                'borderColor' => self::colors('red')
            );
        }
        return $result;
    }
}
