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
        Carbon::setLocale('nl');
    }

    public function show($id){
	    $user = \Auth::user();
	    $userid = $user->id;	
	    $notification = Notification::find($id);
	    if ($userid == $notification->receiver_id){
	    	$notification->read = 1;
	    	$notification->save();
	    	return view('notificationShow')->with('notification', $notification);
	    }
	    else{
	    	return redirect('notificaties');
	    }

    }

    public function index(){
    	if(Auth::check()){
            $user = \Auth::user();
            $userid = $user->id;
            $notifications = Notification::where('receiver_id', '=', $userid)->get();

    		return view('notifyboard')->with('notifications', $notifications);
        }else{
        	return redirect('/topic');
        }
    }
}
