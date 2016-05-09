<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use App\Notification;

use App\Subscription;

use App\Topic;

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

    public function subnotify($id, $user_id, $target){
    $topic = Topic::find($id);
    $subscriptions = Subscription::where('topic_id', '=', $id)->get();
    foreach ($subscriptions as $loops){
    $notifications = new Notification;
    $notifications->topic_id = $id;
    $notifications->user_id = $user_id;
    $notifications->receiver_id = $loops->user_id;
    $notifications->read = 0;
    if ($target == 'comment'){
    $notifications->notification_description = 'Er is een nieuwe reactie geplaatst op een leervraag';
}
else{
	$notifications->notification_description = $topic->topic_description;
}
$notifications->save();
}

    }
}
