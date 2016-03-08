<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use View;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
    	    	$user = \Auth::user();
    	$userid = $user->id;

		DB::table('subscription')->insert([
            ['user_id' => $userid, 'topic_id' => $id]]);
    	return redirect('/topic');
    		
    }
}
