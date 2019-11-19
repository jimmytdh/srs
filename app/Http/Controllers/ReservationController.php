<?php

namespace App\Http\Controllers;

use App\Borrow;
use App\Item;
use App\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function index()
    {
        $date = Session::get('date_reservation');
        if($date)
        {
            $date_start = Carbon::parse($date)->startOfDay();
            $date_end = Carbon::parse($date)->endOfDay();
        }else{
            $date = Carbon::today();
            $date_start = Carbon::parse($date)->startOfDay();
            $date_end = Carbon::parse($date)->endOfDay();
        }

        $reserved = DB::table('reservations')
                        ->whereRaw('"'.$date_start.'" between `date_start` and `date_end`')
                        ->groupBy('code')
                        ->get();
        $items = Item::orderBy('name','asc')->get();


        return view('page.reservation',[
            'menu' => 'reservation',
            'title' => 'Reservation',
            'reserved' => $reserved,
            'items' => $items,
            'date' => $date
        ]);
    }

    public function search(Request $req)
    {
        Session::put('date_reservation',$req->date);
        return redirect()->back();
    }

    public function changeDate($code)
    {
        $r = Reservation::where('code',$code)->first()->date_start;
        $date = Carbon::parse($r)->format('Y-m-d');
        Session::put('date_reservation',$date);
        return redirect()->back();
    }


    public function save(Request $req, $code = false)
    {
        $ids = $req->ids;
        if(!$ids)
        {
            return redirect()->back()->with('status',[
                'title' => 'Invalid',
                'msg' => "No items selected",
                'status' => 'warning'
            ]);
        }
        if($code){
            Reservation::where('code',$code)->delete();
        }else{
            $code = date('ymdHis');
        }

        foreach($ids as $id)
        {
            $data = array(
                'code' => $code,
                'item_id' => $id,
                'date_start' => Carbon::parse("$req->date_start $req->time_start"),
                'date_end' => Carbon::parse("$req->date_end $req->time_end"),
                'time_start' => Carbon::parse("$req->time_start"),
                'time_end' => Carbon::parse("$req->time_end"),
                'user' => $req->user,
                'title' => $req->title,
                'description' => $req->description,
                'status' => 'Reserved'
            );
            Reservation::create($data);
        }
        return redirect()->back()->with('status',[
            'title' => 'Success',
            'msg' => "Item(s) successfully reserved!",
            'status' => 'success'
        ]);
    }

    public function edit($code)
    {
        $info = Reservation::where('code',$code)->first();
        $items = Item::orderBy('name','asc')
            ->get();

        $date = Session::get('date_reservation');


        return view('load.editReservation',[
            'code' => $code,
            'info' => $info,
            'items' => $items,
            'code' => $code
        ]);
    }

    static function getItems($code)
    {
        $data = Item::select('items.name')
                    ->leftJoin('reservations','reservations.item_id','=','items.id')
                    ->where('reservations.code',$code)
                    ->get();
        return $data;
    }

    public function calendar()
    {
        $reserved = Reservation::whereBetween('date_start',[Carbon::now()->startOfYear(),Carbon::now()->endOfYear()])
            ->groupBy('code')
            ->get();

        $result = array();
        foreach($reserved as $row)
        {
            $result[] = array(
                'title' => $row->title,
                'description' => "Borrower: $row->user<br>Description/Location: $row->description<br>Items: ".self::getItems($row->code)->pluck('name')->implode(', '),
                'start' => Carbon::parse($row->date_start)->format('Y-m-d')." ".Carbon::parse($row->time_start)->format('H:i:s'),
                'end' => Carbon::parse($row->date_end)->format('Y-m-d')." ".Carbon::parse($row->time_end)->format('H:i:s'),
                'allDay' => 'true',
                'url' => url('reservation/change/date/'.$row->code),
                'backgroundColor' => '#00a65a',
                'borderColor' => '#00a65a'
            );
        }

        return $result;
    }

    public function cancel($code)
    {
        Reservation::where('code',$code)->delete();
        return redirect()->back()->with('status',[
            'title' => 'Success',
            'msg' => "Reservation successfully cancelled!",
            'status' => 'success'
        ]);
    }

    public function borrow($code)
    {
        $res = Reservation::where('code',$code)->get();

        $items = Reservation::select('item_id')->where('code',$code)->get();

        $isBorrowed = Item::where('status','Borrowed')
                    ->whereIn('id',$items)
                    ->first();
        if($isBorrowed)
        {
            return redirect()->back()->with('status',[
                'title' => 'Invalid',
                'msg' => "Oppss. Item(s) are not available at the moment!",
                'status' => 'warning'
            ]);
        }

        foreach($res as $r)
        {
            Reservation::where('id',$r->id)
                ->update(['status' => 'Borrowed']);
            $data = array(
                'item_id' => $r->item_id,
                'date_borrowed' => Carbon::now(),
                'user_borrowed' => $r->user,
                'remarks_borrowed' => $r->title
            );
            Borrow::create($data);
            Item::find($r->item_id)
                ->update([
                    'status' => 'Borrowed'
                ]);
        }
        return redirect()->back()->with('status',[
            'title' => 'Success',
            'msg' => "Item(s) successfully borrowed!",
            'status' => 'success'
        ]);
    }

    public function checkAvailable($date,$time_start, $time_end, $code)
    {
        $output = '
            <div class="alert bg-danger">
                No available items on selected date!             
            </div>
        ';

        $time_start = Carbon::parse("$time_start")->format('H:i:s');
        $time_end = Carbon::parse("$time_end")->format('H:i:s');
        $i = Reservation::where('date_start',$date)
                ->select('item_id')
                //->where('time_start','>=',$time_start)
                //->where('time_end','<=',$time_end)
                ->where(function ($q) use($time_start,$time_end){
                    $q->whereBetween('time_start',[$time_start,$time_end]);
                })
                ->where(function ($q) use($time_start,$time_end){
                    $q->whereBetween('time_end',[$time_start,$time_end]);
                });
        if($code!='new')
        {
            $i = $i->where('code',$code);
        }

        $i = $i->get();

        $items = Item::whereNotIn('id',$i)->orderBy('name','asc')->get();

        if(count($items)==0)
            return $output;

        $output = '<label>Item(s) Available</label><br>';

        foreach($items as $row)
        {
            $output .= '
                <div class="col-sm-6 no-padding">
                    <label>
                        <input type="checkbox" name="ids[]" value="'.$row->id.'" class="minimal"> '.$row->name.'
                    </label>
                </div>
            ';
        }

        if($code == 'new') {
                $output .= '
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success btn-flat btn-block">
                        <i class="fa fa-check"></i> Reserve/Update
                    </button>
                </div>
            ';
        }

        return $output;
    }

    static function isItemByCode($id,$code)
    {
        $check = Reservation::where('code',$code)->where('item_id',$id)->first();
        if($check)
            return true;
        return false;
    }
}
