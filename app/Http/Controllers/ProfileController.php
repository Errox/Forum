<?php

namespace App\Http\Controllers;

use App\Http\Requests;

Use App\User;

Use Request;

use Carbon\Carbon;


class ProfileController extends Controller
{
  public function __construct()
    {
        //$this->middleware('auth');
        Carbon::setLocale('nl');
    }
  public function index(){
   	$profile = User::all();
  
    return view('profile')->with('profile', $profile);
  }

  public function show($id){
    $profile = User::where('id', '=', $id)->get();
    
    return view('profileShow')->with(compact('profile', 'id'));
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
    return view('profileEdit')->with('profile', $profile);
  }

    public function update($id){
    	$input = Request::all();

    	$update = User::find($id);
    	$update->email = $input['email'];
    	$update->name = $input['username'];
      $update->about = $input['about'];
    	$update->save();

    	return redirect('/profile/'.$id);
    }

}
