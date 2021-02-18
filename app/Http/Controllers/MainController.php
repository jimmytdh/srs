<?php

namespace App\Http\Controllers;

use App\section;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('isLogin');
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register',[
            'sections' => section::orderBy('name','asc')->get()
        ]);
    }

    public function validateLogin(Request $req)
    {
//        $login = User::where('username',$req->username)->first();
//        if($login)
//        {
//            if(Hash::check($req->password,$login->password))
//            {
//                if($login->status=='inactive'){
//                    return redirect('login')->with('status','inactive');
//                }else if($login->status=='banned'){
//                    return redirect('login')->with('status','banned');
//                }
//
//                Session::put('user',$login);
//                Session::put('isLogin',true);
//
//                return redirect('/');
//
//            }else{
//                return redirect('login')->with('status','error');
//            }
//        }else{
//            return redirect('login')->with('status','error');
//        }
        $remember = ($req->remember) ? true: false;
        if(Auth::attempt(['username' => $req->username, 'password' => $req->password], $remember )){
            if(!auth()->user()->allowed()){
                Auth::logout();
                return redirect('login')->with('status','denied');
            }
            Session::put('isLogin',true);
            return redirect()->intended('/');
        }
        return redirect('login')->with('status','error');
    }
}
