<?php

namespace App\Http\Controllers;

use App\Borrow;
use App\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function index()
    {
        $keyword = Session::get('searchItem');
        $data = Item::select('*');
        if($keyword){
            $data = $data->where(function($q) use ($keyword){
                $q->where('name','like',"%$keyword%")
                    ->orwhere('description','like',"%$keyword%");
            });
        }

        $available = Item::orderBy('name','asc')->where('status','Available')->get();
        $borrowed = Item::orderBy('name','asc')->where('status','Borrowed')->get();

        $data = $data
                ->orderBy('status','asc')
                ->orderBy('name','asc')
                ->paginate(30);

        return view('page.item',[
            'menu' => 'items',
            'data' => $data,
            'available' => $available,
            'borrowed' => $borrowed
        ]);
    }

    public function search(Request $req)
    {
        Session::put('searchItem',$req->keyword);
        return redirect()->back();
    }

    public function save(Request $req)
    {
        $data = array(
            'name' => $req->name,
            'description' => $req->description
        );

        $validateName = Item::where($data)->first();
        if(!$validateName) {
            $data['status'] = $req->status;
            Item::create($data);
            return redirect('/items')->with('status',[
                'status' => 'success',
                'title' => 'Added',
                'msg' => $req->name.' successfully added!'
            ]);

        }

        return redirect()->back()->with('status',[
            'title' => 'Duplicate',
            'msg' => "Item was already added in the system!",
            'status' => 'error'
        ]);
    }

    public function edit($id)
    {
        $data = Item::find($id);
        return view('load.editItem',[
            'id' => $id,
            'data' => $data
        ]);
    }

    public function update(Request $req, $id)
    {
        $data = array(
            'name' => $req->name,
            'description' => $req->description
        );

        if($req->status)
        {
            $data['status'] = $req->status;
        }
        $validate = Item::where($data)
            ->where('id','<>',$id)
            ->first();
        if($validate){
            return redirect()->back()->with('status',[
                'title' => 'Duplicate',
                'msg' => "Item was already added to the system!",
                'status' => 'error'
            ]);
        }
        $data = Item::where('id',$id)
            ->update($data);

        return redirect()->back()->with('status',[
            'status' => 'success',
            'title' => 'Updated',
            'msg' => $req->name.' successfully updated!'
        ]);
    }

    public function delete($id)
    {
        Item::find($id)->delete();

        return redirect()->back()->with('status',[
            'title' => 'Success',
            'msg' => 'Item(s) successfully deleted',
            'status' => 'success'
        ]);
    }

    static function borrowInfo($id)
    {
        $info = Borrow::where('item_id',$id)
                ->orderBy('id','desc')
                ->first();
        if($info)
            return $info;

        return false;
    }

    static function status($status)
    {
        $class = 'yellow';
        $icon = 'times';

        if($status=='Available'){
            $class = 'green';
            $icon = 'circle';
        }else if($status=='Borrowed'){
            $class = 'red';
            $icon = 'circle-o';
        }

        //$string = "<font class='text-$class'><i class='fa fa-$icon'></i> $status</font>";
        $string = "<span class='badge bg-$class'>$status</span>";
        return $string;
    }

    public function borrow(Request $req)
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

        foreach($ids as $id)
        {
            $data = array(
                'item_id' => $id,
                'date_borrowed' => Carbon::parse("$req->date $req->time"),
                'user_borrowed' => $req->user,
                'remarks_borrowed' => $req->remarks
            );
            Borrow::create($data);
            Item::find($id)
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

    public function returnItem(Request $req)
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

        foreach($ids as $id)
        {
            $data = array(
                'date_returned' => Carbon::parse("$req->date $req->time"),
                'user_returned' => $req->user,
                'remarks_returned' => $req->remarks
            );
            $borrow_id = Borrow::where('item_id',$id)->orderBy('id','desc')->first()->id;
            Borrow::where('id',$borrow_id)->update($data);
            Item::find($id)
                ->update([
                    'status' => 'Available'
                ]);
        }

        return redirect()->back()->with('status',[
            'title' => 'Success',
            'msg' => "Item(s) successfully returned!",
            'status' => 'success'
        ]);
    }
}
