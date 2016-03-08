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


        DB::table('comments')->insert([
            ['user_id' => $userid, 'topic_id' => $input['title'], 'topic_description' => $input['description']]
        ]);

        $last = DB::table('topics')->orderBy('id', 'desc')->first();
        DB::table('tags_topic')->insert([
            ['topic_id' => $last->id, 'tag_id' => $input['tag']]]);

    	return $input;

    }

    public function destroy(){
    	//This function is used to archive comments. A comment will never be deleted.
    }


}
