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
  		if ($user->role == 1){
  			return view('profile/gebruikers')->with(compact('profile'));
  		}
  	}
    // Hier worden users heen gestuurd die geen leeraar zijn met beperkte informatie.
    return view('profile')->with(compact('profile', 'user'));
}

  // Deze functie pakt de informatie voor een specifiek profiel en stuurt je door naar de juiste blade.php
  public function show($id){
    $profile = User::find($id);
    
    return view('profile/profileShow')->with(compact('profile', 'id'));
  }

  // Deze functie pakt de informatie om de gebruiker zijn eigen profiel aan te laten passen en stuurt je door naar de juiste blade.php
  public function edit($id){
    // Hier word eerst gekeken of de ingelogde gebruiker ook de gebruiker is die aangepast gaat worden.
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
    return view('profile/profileEdit')->with('profile', $profile);
  }

  // Hier word alles van het profiel geüpdatet met de nieuwe informatie.
  public function update($id){
    // Hier word eerst alle data van de ingevoerde velden opgehaald
    $input = Request::all();
    $update = User::find($id);
    // Hier word opgehaald welke keuzes de gebruiker heeft gemaakt met betrekking tot zijn privacy.
    $privacy = User_privacy::where('user_id', '=', $id)->get();
    $update->email = $input['email'];
    $update->name = $input['username'];
    $update->about =  nl2br($input['about']);

    // Hier word de nieuwe settings voor zijn email geüpdatet, of het wel of niet getoont mag worden.

    if(empty($input['email_privacy'])){
      $input['email_privacy'] = 0;
    }else{
      $input['email_privacy'] = 1;
    }

    $privacy[0]->email_active = $input['email_privacy'];
    $privacy[0]->save();
    
    $update->save();
    return redirect('/profile/'.$id);
  }

  public function result(){
    // Hier worden alle users opgehaald
    $profile = User::all();
    if (\Auth::check()){
      $user = \Auth::user();
    }
    

        return view('profile/gebruikers')->with(compact('profile'));
     
    // Hier worden users heen gestuurd die geen leeraar zijn met beperkte informatie.
    return view('profile')->with(compact('profile', 'user'));
  }

}
