<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use App\Notification;

use Carbon\Carbon;

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
    	echo 'hoi';
    }

    public function index(){
    	if(Auth::check()){
            $user = \Auth::user();
            $userid = $user->id;
            $notifications = Notification::where('reciever_id', '=', $userid)->get();

    		return view('notifyboard')->with('notifications', $notifications);
        }else{
        	return redirect('/topic');
        }
    }
}
