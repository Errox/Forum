<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;

use App\Comment;

use App\Notification;

class CommentController extends Controller
{
    public function store(){
		// request all inputs    	
    	$input = Request::all();
    	//all user id's
    	$user = \Auth::user();
    	$userid = $user->id;

        $comment = new Comment;

        $comment->user_id = $userid;
        $comment->topic_id = $input['id'];
        $comment->comment_description =  nl2br($input['comment_description']);
        $comment->save();

        // $notification = new Notification;

        // $notification->user_id = $userid;
        // $notification->topic_id = $input['id'];
        // $notification->notification_description = ' heeft een comment op je leervraag gegeven.';
        // $notification->receiver_id = '1';
        // $notification->save;

    	return redirect('topic/'.$input['id']);

    }

    public function destroy(){
    	//This function is used to archive comments. A comment will never be deleted.
    }


}
