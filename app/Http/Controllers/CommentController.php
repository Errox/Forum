<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;

use App\Comment;

use App\Topic;

use Carbon\Carbon;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        Carbon::setLocale('nl');
    }
    
    public function store(){
		
        // request all inputs    	
    	$input = Request::all();
        $id = $input['id'];
    	
        //all user id's
    	$user = \Auth::user();
    	$userid = $user->id;

        //Nieuwe comment wordt hier gemaakt
        $comment = new Comment;

        //De nieuwe comment wordt hier ingevuld met data op elk specefiek veld.
        $comment->user_id = $userid;
        $comment->topic_id = $input['id'];
        $comment->comment_description =  $input['comment_description'];
        $comment->save();
        $target = 'comment';

        //Er wordt hier een notificatie gestuurd naar de maker van de topic.
        app('App\Http\Controllers\NotificationController')->subnotify($id, $userid, $target);

        //Redirect naar de topic waar de comment is gevoerd.
    	return redirect('topic/'.$input['id']);

    }

    public function destroy(){
    	//This function is used to archive comments. A comment will never be deleted.
    }


}

