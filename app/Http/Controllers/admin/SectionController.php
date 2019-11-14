<?php

namespace App\Http\Controllers\admin;

use App\Division;
use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $data = self::getData();
        $divisions = Division::orderBy('description','asc')->get();

        return view('admin.section',[
            'title' => 'List of Sections',
            'data' => $data,
            'menu' => 'section',
            'divisions' => $divisions
        ]);
    }

    public function getData()
    {
        $keyword = Session::get('search_section');
        $data = Section::select('section.*','division.description as division')
            ->addSelect(DB::raw("(select count(user.id) from user where user.section = section.id) as num"))
            ->leftJoin('division','section.division_id','=','division.id')
            ->orderBy('code','asc');
        if($keyword){
            $data = $data->where('section.code','like',"%$keyword%")
                ->orwhere('section.description','like',"%$keyword%");
        }
        $data = $data->paginate(30);
        return $data;
    }

    public function save(Request $req)
    {
        Section::create([
            'initial' => $req->initial,
            'code' => $req->code,
            'description' => $req->description,
            'division_id' => $req->division
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
        $info = Section::find($id);
        if(!$info){
            return redirect('/admin/section')->with('status',[
                'title' => 'Access Denied',
                'msg' => "You have no access in this section!",
                'status' => 'error'
            ]);
        }
        $divisions = Division::orderBy('description','asc')->get();

        return view('admin.section',[
            'title' => $info->description,
            'data' => $data,
            'info' => $info,
            'menu' => 'section',
            'edit' => true,
            'divisions' => $divisions
        ]);
    }

    public function update(Request $req, $id)
    {
        Section::find($id)
            ->update([
                'initial' => $req->initial,
                'code' => $req->code,
                'description' => $req->description,
                'division_id' => $req->division
            ]);

        return redirect()->back()->with('status',[
            'title' => 'Success',
            'msg' => $req->description." successfully updated!",
            'status' => 'success'
        ]);
    }

    public function delete($id)
    {
        Section::find($id)->delete();
        return redirect('admin/section')->with('status',[
            'title' => 'Success',
            'msg' => "Successfully deleted!",
            'status' => 'info'
        ]);
    }

    public function search(Request $req)
    {
        Session::put('search_section',$req->keyword);
        return redirect()->back();
    }
}
