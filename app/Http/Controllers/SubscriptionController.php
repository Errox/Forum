<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;

use App\Subscription;

use View;

use App\Topic;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Opslaan van de aanmelding
    public function store(){
    	$input = Request::all();
      //checken of id wel bestaad
      if (!isset($input['id'])){
        $topic_id = Topic::all()->last();
        $topic_id = $topic_id->id;
      }
      else{            
    		$topic_id = $input['id']; 
      }

    	$user = \Auth::user();
      $userid = $user->id;

      //aanmelding opslaan.
    	$subscription = new Subscription; 
    	$subscription->topic_id = $topic_id;
      $subscription->user_id = $userid;	
    	$subscription->save();

		  /*/ DB::table('subscription')->insert([
        ['user_id' => $userid, 'topic_id' => $topic_id]]);/*/
    	
      return redirect('/topic/'.$topic_id);
    		
    }

    //aanmelding verwijderen.
    public function destroy($id){
      $user = \Auth::user();
      $userid = $user->id;

      //destory aanmelding
     	Subscription::where('user_id', $userid)
     	  ->where('topic_id', $id)
     	  ->delete();

    //  	$test = DB::table('subscription')
    //     ->where('topic_id', '=', $id)
    //  		->where('user_id', '=', $userid)
    //  		->delete();
      return redirect('/topic/'.$id);
    }
}
