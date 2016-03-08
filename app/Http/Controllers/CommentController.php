<?php

namespace App\Http\Controllers;

use Request;

use DB;

use App\Http\Requests;

class CommentController extends Controller
{
    public function store(){
		// request all inputs    	
    	$input = Request::all();
    	//all user id's
    	$user = \Auth::user();
    	$userid = $user->id;
        $topic_id = $input['id'];


        DB::table('comments')->insert([
            ['user_id' => $userid, 'topic_id' => $topic_id, 'comment_description' => $input['comment_description']]
        ]);

    	return redirect('topic/'.$topic_id);

    }

    public function destroy(){
    	//This function is used to archive comments. A comment will never be deleted.
    }


}
