<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;

use App\topic;

use App\tag;

use DB;

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

    	$result[0] = Topic::find($id);

        $result[1] = DB::table('topics')
            ->leftJoin('comments', 'topics.id', '=', 'comments.topic_id')
            ->leftJoin('users', 'comments.user_id', '=', 'users.id')
            ->select('users.name', 'comments.topic_id', 'comments.comment_description', 'comments.created_at')
            ->where('comments.topic_id', '=', $id)
            ->get();

        $result[2] = DB::table('subscriptions')
            ->select('user_id', 'topic_id')
            ->where('topic_id', '=', $id) 
            ->where('user_id', '=', $userid)
            ->get();

    	return view('topicShow')->with('result', $result);
    }


}
