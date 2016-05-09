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
        //$this->middleware('auth');
        Carbon::setLocale('nl');
    }
    
    public function notification($id){
    	Notification::where('receiver_id', '=', $id);

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
