<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;

use App\topic;

use App\tag;

use App\Comment;

use App\Subscription;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.	
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Topic::all();
        return \View::make('topics')->with('result', $result);
    }

    public function create()
    {
        $tags = Tag::all();
    	return view('create_topic')->with('tags', $tags);
    }

    public function store()
    {
        $user = \Auth::user();
        $userid = $user->id;

        $input = Request::all();

        $topic = new Topic;

        $topic->user_id = $userid;
        $topic->topic_title = $input['title'];
        $topic->topic_description = $input['description'];
        $topic->save();

        return "hierbij ga je nu naar de andere pagina";
    }

    public function show($id){
        //Specific topic/username
            $user = \Auth::user();
            $userid = $user->id;

    	$result[0] = Topic::where('id', '=', $id)->get();

        $result[1] = Comment::where('topic_id', '=', $id)->get();

        $result[2] = Subscription::where('user_id', '=', $userid)
                                  ->where('topic_id', '=', $id)
                                  ->get(); 

    	return view('topicShow')->with('result', $result);
    }


}
