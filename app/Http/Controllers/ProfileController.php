<?php

namespace App\Http\Controllers;


use App\Http\Requests;

Use App\User;

Use Request;

class ProfileController extends Controller
{
    public function index(){
    	$profile = User::all();
    	$index = true;
    	return view('profile')->with(compact('profile', 'index'));

    }

    public function show($id){
   $profile = User::where('id', '=', $id)->get();
   $show = true;
   return view('profile')->with(compact('profile', 'show', 'id'));
    }

    public function edit($id){
   $profile = User::where('id', '=', $id)->get();
   if (\Auth::check()){
   $user = \Auth::user();
   if ($id != $user->id){
   	return redirect('/profile/'.$id);
   }
}
else{
	return redirect('/profile/'.$id);
}
   $edit = true;
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
