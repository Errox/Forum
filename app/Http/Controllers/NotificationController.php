<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use App\Notification;

class NotificationController extends Controller
{

	    public function __construct()
    {
        $this->middleware('auth');
       // Carbon::setLocale('nl');
    }
    public function notification(){
           $user = \Auth::user();
           $userid = $user->id; 
    	$test = Notification::where('receiver_id', '=', $userid)
    						->get();
    	dd($test);
    }

    public function show($id){
    $notification = Notification::find($id)->get();
    	dd($notification);

    }
}
