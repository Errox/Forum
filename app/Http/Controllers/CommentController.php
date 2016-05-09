<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;

use App\Comment;

use App\Topic;

class CommentController extends Controller
{
    public function store(){
		// request all inputs    	
    	$input = Request::all();
        $id = $input['id'];
    	//all user id's
    	$user = \Auth::user();
    	$userid = $user->id;

        $comment = new Comment;

        $comment->user_id = $userid;
        $comment->topic_id = $input['id'];
        $comment->comment_description =  nl2br($input['comment_description']);
        $comment->save();
        $target = 'comment';

       app('App\Http\Controllers\NotificationController')->subnotify($id, $userid, $target);

    	return redirect('topic/'.$input['id']);

    }

    public function destroy(){
    	//This function is used to archive comments. A comment will never be deleted.
    }


}

