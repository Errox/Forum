<?php

namespace App\Http\Controllers;


use App\Http\Requests;

Use App\User;

Use Request;

class ProfileController extends Controller
{
    public function index($id){


    }

    public function show($id){
   $profile = User::where('id', '=', $id)->get();
   return view('profile')->with('profile', $profile);
    }

    public function edit($id){
   $profile = User::where('id', '=', $id)->get();
   $edit = 'edit';
   return view('profile')->with(compact('profile', 'edit'));
    }

    public function update($id){
    	$input = Request::all();

    	$update = User::find($id);
    	$update->email = $input['email'];
    	$update->name = $input['username'];
    	$update->save();

    	return redirect('/profile/'.$id);
    }

}
