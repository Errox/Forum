<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use App\Queue_teacher;

use DB;

class ResultController extends Controller
{
    public function index(){

    // Hier worden alle users opgehaald
    $users = User::all();




    $results = DB::table('queue_teachers')
             ->select('student_id', DB::raw('count(*) as total'))
             ->all()
             ->groupBy('student_id')
             ->lists('total','student_id');
    dd($results);
    
    return view('result/result')->with(compact('users', 'result'));


  }
}
