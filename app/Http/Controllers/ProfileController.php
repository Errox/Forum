<?php

namespace App\Http\Controllers;

use App\Http\Requests;

Use App\User;

Use App\User_privacy;

Use Request;

use Carbon\Carbon;

use App\Queue_teacher;


class ProfileController extends Controller
{
  public function __construct()

    { // In de construct staat alles wat ingeladen word als de controller aangeroepen word.
        //$this->middleware('auth');
        Carbon::setLocale('nl');
    }
  // In de Index staat alles wat gebruikt word op de pagina en stuurt je door naar de pagina.  

  public function index(){
    // Hier worden alle users opgehaald
   	$profile = User::all();
  	if (\Auth::check()){
  	  $user = \Auth::user();
  	}
    // Hier word gekeken of er iemand is ingelogd. Als de user een leeraar is word de user doorgestuurd naar een andere view met meer informatie.
  	if (isset($user)){
  		if ($user->role != 0){
  			return view('profile/gebruikers')->with(compact('profile'));
  		}
  	}
    // Hier worden users heen gestuurd die geen leeraar zijn met beperkte informatie.
    return view('profile/profile')->with(compact('profile', 'user'));
}

  // Deze functie pakt de informatie voor een specifiek profiel en stuurt je door naar de juiste blade.php
  public function show($id){
    $profile = User::find($id);
    $privacy = User_privacy::where('user_id', '=', $id)->get();
    if (\Auth::check()){
      $user = \Auth::user();
    }
     return view('profile/profileShow')->with(compact('profile', 'privacy', 'id'));
  }

  // Deze functie pakt de informatie om de gebruiker zijn eigen profiel aan te laten passen en stuurt je door naar de juiste blade.php
  public function edit($id){
    // Hier word eerst gekeken of de ingelogde gebruiker ook de gebruiker is die aangepast gaat worden.
    $profile = User::where('id', '=', $id)->get();
    if (\Auth::check()){
      $user = \Auth::user();
      $userid = $user->id;
      if ($id != $user->id){
       	return redirect('profile/profile/'.$id);

      }
    }
    else{
      return redirect('profile/profile/'.$id);
    }
    $privacy = User_privacy::where('user_id', '=', $userid)->get();
    return view('profile/profileEdit')->with(compact('profile', 'privacy'));
  }

  // Hier word alles van het profiel geüpdatet met de nieuwe informatie.
  public function update($id){
    // Hier word eerst alle data van de ingevoerde velden opgehaald
    $input = Request::all();
    $update = User::find($id);
    // Hier word opgehaald welke keuzes de gebruiker heeft gemaakt met betrekking tot zijn privacy.
    $privacy = User_privacy::where('user_id', '=', $id)->get();
    $update->email = $input['email'];
    //$update->name = $input['username'];
    $update->about =  $input['about'];

    // Hier word de nieuwe settings voor zijn email geüpdatet, of het wel of niet getoont mag worden.

    if(empty($input['email_privacy'])){
      $input['email_privacy'] = 0;
    }else{
      $input['email_privacy'] = 1;
    }

    $privacy[0]->email_active = $input['email_privacy'];
    $privacy[0]->save();
    
    $update->save();
    return redirect('profile/profile/'.$id);
  }

  public function passwordChange(){
    $input = \Request::all();
    if (\Auth::check()){
      $user = \Auth::user();
      $userid = $user->id;
    }

    $user = user::find($userid);
    $profile = User::where('id', '=', $userid)->get();
    $privacy = User_privacy::where('user_id', '=', $userid)->get();

    $oldPassword = $input['passwordOld'];


    if(\Hash::check($oldPassword, $user->password)){
      
      $hashed = \Hash::make($oldPassword);
        
      $user->password = bcrypt($input['passwordNew']);
      $user->save();
      \Session::flash('flash_message_succes', 'Je wachtwoord is succesvol verranderd');
      return view('profile/profileEdit')->with(compact('profile', 'privacy'));
    }else{
      \Session::flash('flash_message_alert', 'Je oude wachtwoord klopt niet met het orginele wachtwoord');
      return view('profile/profileEdit')->with(compact('profile', 'privacy'));
    }
  }
}
