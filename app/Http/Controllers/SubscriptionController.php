<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;

use App\Subscription;

use View;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store()
    {

    	$input = Request::all();
		$topic_id = $input['id']; 
		$user = \Auth::user();
    	$userid = $user->id;

		$subscription = new Subscription;   
		$subscription->topic_id = $topic_id;
		$subscription->user_id = $userid;	
		$subscription->save();

		/*/ DB::table('subscription')->insert([
        ['user_id' => $userid, 'topic_id' => $topic_id]]);/*/
    	
      return redirect('/topic/'.$topic_id);
    		
    }

    // public function destroy($id){
    //   $user = \Auth::user();
    //  	$userid = $user->id;


     	Subscription::where('user_id', $userid)
     							  ->where('topic_id', $id)
     							  ->delete();

    //  	$test = DB::table('subscription')
    //     ->where('topic_id', '=', $id)
    //  		->where('user_id', '=', $userid)
    //  		->delete();
    //  	return redirect('/topic/'.$id);
    // }
}
