<?php

namespace App\Http\Controllers;

use App\IPAddress;
use Illuminate\Http\Request;

class IPController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function index($range)
    {
        $keyword = \Illuminate\Support\Facades\Session::get('searchNetIP');

        $data = array();

        $type = ($range==5) ? 'net' : 'homis';

        return view('page.ip',[
            'menu' => 'ip',
            'data' => $data,
            'range' => $range,
            'type' => $type,
            'sub' => "$range.$range"
        ]);
    }

    public function update(Request $req, $type,$ip)
    {
        $data = array(
            'owner' => $req->owner,
            'section' => $req->section,
            'mac' => $req->mac
        );

        $match = array(
            'type' => $type,
            'ip' => $ip
        );
        IPAddress::updateOrcreate($match, $data);
        return redirect()->back()->with('success',"$type$ip");
    }

    static function getName($type,$ip)
    {
        $data = IPAddress::where('type',$type)
                    ->where('ip',$ip)
                    ->first();
        if(!$data){
            $data = array(
                'owner' => '',
                'section' => '',
                'mac' => ''
            );
            $data = (object)$data;
        }

        return $data;
    }
}
