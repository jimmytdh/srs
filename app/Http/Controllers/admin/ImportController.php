<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImportController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(){
        return view('page.error',[
            'title' => 'Page not found!',
            'menu' => 'import'
        ]);
    }
}
