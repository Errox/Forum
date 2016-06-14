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


    dd($users->Queue_teachers);
    return view('result/result')->with(compact('users'));


  }
}
