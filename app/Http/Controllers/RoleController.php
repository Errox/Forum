<?php

namespace App\Http\Controllers;

use Auth;

use Request;

use App\Http\Requests;

use App\Topic;

use App\Tag;

use App\Comment;

use App\Subscription;

use App\User;

use Carbon\Carbon;


class RoleController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
        Carbon::setLocale('nl');
    }
    
    public function index(){
        // De data van topic, met user, en aanmeldingen worden hier in het result variabel door gegeven
		$result[0] = Topic::with('user')->with('tag')->with('subscriptions')->get()->sortBy(function($topic){
            return $topic->subscriptions->count();
        },$options = SORT_REGULAR, $descending = true );

        //Een view wordt hier gereturnd met het result variabel.
    	return view('beheer/beheer')->with('result', $result);
    }

    public function show($id){
        //Een user wordt gevonden met het id die de functie meekrijgt.
        $result = User::find($id);

        //Er wordt gecheckd of de user wel de goeie rol heeft.
        if($result->role == 1){
            //Als role 1 is wordt de gebruiker 0 dus leerling
            $result->role = 0;
        }
        else{
            //Als role 0 is wordt de gebruiker 1 dus leeraar.
            $result->role = 1;
        }
        
        //De weizinginen worden opgeslagen, en de gebruiker wordt terug gestuurd naar de orginele locatie
        $result->save();
        return redirect('/profile');
    }
    
}