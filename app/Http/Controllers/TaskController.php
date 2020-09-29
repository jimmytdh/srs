<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function index()
    {
        $data = Task::paginate(10);

        return view('page.task',[
            'data' => $data,
            'menu' => 'task'
        ]);
    }
}
