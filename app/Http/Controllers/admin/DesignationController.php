<?php

namespace App\Http\Controllers\admin;

use App\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $data = self::getData();

        return view('admin.designation',[
            'title' => 'List of Designations',
            'data' => $data,
            'menu' => 'designation'
        ]);
    }

    public function getData()
    {
        $keyword = Session::get('search_designation');
        $data = Designation::select('designation.*')
                    ->addSelect(DB::raw("(select count(user.id) from user where user.designation = designation.id) as num"))
                    ->orderBy('code','asc');
        if($keyword){
            $data = $data->where('code','like',"%$keyword%")
                        ->orwhere('description','like',"%$keyword%");
        }
        $data = $data->paginate(30);
        return $data;
    }

    public function save(Request $req)
    {
        Designation::create([
            'code' => $req->code,
            'description' => $req->description
        ]);

        return redirect()->back()->with('status',[
            'title' => 'Success',
            'msg' => $req->description." successfully saved!",
            'status' => 'success'
        ]);
    }

    public function edit($id)
    {
        $data = self::getData();
        $info = Designation::find($id);
        if(!$info){
            return redirect('/admin/designation')->with('status',[
                'title' => 'Access Denied',
                'msg' => "You have no access in this section!",
                'status' => 'error'
            ]);
        }

        return view('admin.designation',[
            'title' => $info->description,
            'data' => $data,
            'info' => $info,
            'menu' => 'designation',
            'edit' => true
        ]);
    }

    public function update(Request $req, $id)
    {
        Designation::find($id)
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
        Designation::find($id)->delete();
        return redirect('admin/designation')->with('status',[
            'title' => 'Success',
            'msg' => "Successfully deleted!",
            'status' => 'info'
        ]);
    }

    public function search(Request $req)
    {
        Session::put('search_designation',$req->keyword);
        return redirect()->back();
    }
}
