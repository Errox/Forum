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

	//kijken of gebruiker is ingelogd en de carbon op nederlands zetten
	public function __construct()
    {
        $this->middleware('auth');
        Carbon::setLocale('nl');
    }
    //Hier worden alle notifications opgevraagd die voor de gebruiker zijn.
    public function index(){
    	if(Auth::check()){
            $user = \Auth::user();
            $userid = $user->id;
            $notifications = Notification::where('receiver_id', '=', $userid)->get();

    		return view('notification')->with('notifications', $notifications);
        }else{
        	return redirect('/topic');
        }
    }

    //notification op gelezen zetten zodat de notificatie niet meer een hoge prioriteit hebben.
    public function show($id){
	    $user = \Auth::user();
	    $userid = $user->id;	
	    $notification = Notification::find($id);
	    if ($userid == $notification->receiver_id){
	    	//hier wordt de notificatie op gelezen gezet.
	    	$notification->read = 1;
	    	$notification->save();
	    	return redirect('notificaties');
	    }
	    else{
	    	return redirect('notificaties');
	    }

    }

    //hier wordt een text mee gegeven zodat de gebruiker weet waar de notificatie over gaat
    public function subnotify($id, $user_id, $target){
   		$topic = Topic::find($id);
   		$subscriptions = Subscription::where('topic_id', '=', $id)->get();
	    
	    foreach ($subscriptions as $loops){
		    $notifications = new Notification;
		    $notifications->topic_id = $id;
		    $notifications->user_id = $user_id;
		    $notifications->receiver_id = $loops->user_id;
		    $notifications->read = 0;
		    if ($user_id == $loops->user_id){
		    	continue;
		    }
		    if ($target == 'comment'){
		    	$notifications->notification_description = 'heeft een nieuwe reactie geplaatst op een leervraag';
			}
			else{
				$notifications->notification_description = $topic->topic_description;
			}
			$notifications->save();
		}

	}
}
