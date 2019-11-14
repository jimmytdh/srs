<?php

namespace App\Http\Controllers;

use App\Activity;
use App\chat;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function password(Request $req)
    {
        $user = Session::get('user');
        if(Hash::check($req->current,$user->password))
        {
            if($req->password==$req->confirm){
                User::find($user->id)
                    ->update([
                        'password' => bcrypt($req->password)
                    ]);
                return redirect()->back()->with('status', array(
                    'title' => 'Success',
                    'msg' => "Password successfully changed!",
                    'status' => 'success'
                ));
            }else{
                return redirect()->back()->with('status', array(
                    'title' => 'Error',
                    'msg' => "Password didn't match. Please try again!",
                    'status' => 'error'
                ));
            }

        }else{
            return redirect()->back()->with('status', array(
                'title' => 'Error',
                'msg' => "Incorrect Password. Please try again!",
                'status' => 'error'
            ));
        }
    }

    public function profile()
    {
        return view('page.error',[
            'title' => 'Page not found!',
            'menu' => 'profile'
        ]);
    }
}
