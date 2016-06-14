<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use App\queue_comment;

class ResultController extends Controller
{
    public function index(){

	    // Hier worden alle users opgehaald
	    $users = User::all();


	    return view('result/result')->with(compact('users'));


  }
}
