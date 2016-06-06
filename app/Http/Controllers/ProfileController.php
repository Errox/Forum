<?php

namespace App\Http\Controllers;

use App\Http\Requests;

Use App\User;

Use App\User_privacy;

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
  	if (\Auth::check()){
  	  $user = \Auth::user();
  	}

  	if (isset($user)){
  		if ($user->role == 1){
  			return view('gebruikers')->with(compact('profile'));
  		}
  	}


    return view('profile')->with(compact('profile', 'user'));

  }

  public function show($id){
    $profile = User::find($id);
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
      $privacy = User_privacy::where('user_id', '=', $id)->get();
    	$update->email = $input['email'];
    	$update->name = $input['username'];
      $update->about =  nl2br($input['about']);
      if(empty($input['email_privacy'])){
        $input['email_privacy'] = 0;
      }
      else{
        $input['email_privacy'] = 1;
      }
        $privacy[0]->email_active = $input['email_privacy'];
        $privacy[0]->save();
      
      $update->save();
    	return redirect('/profile/'.$id);
    }

}
