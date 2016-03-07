<?php

namespace App\Http\Controllers;

use Request;

use DB;

use App\Http\Requests;

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
        $topic = array(
    		'topic' => \App\topics::all()
    		//'tags' => App\tags::all()
    		);
    	return view('topics', $topic);
    }

    public function create()
    {
    	return view('create_topic');
    }

    public function store()
    {
    	$input = Request::all();

    	$user = \Auth::user();
    	$userid = $user->id;

    	var_dump($userid);

    	echo $input['title'];

    	DB::table('topics')->insert([
    		['user_id' => $userid, 'topic_title' => $input['title'], 'topic_description' => $input['description'] ]
    	]);

    	return redirect('/home');
    }

    public function show($id){
    	$result = DB::table('topics')
    		->leftJoin('users', 'topics.user_id', '=', 'users.id')
    		->select('topics.id','users.name','topics.topic_title','topics.topic_description','topics.topic_tag')
    		->where('topic.id', '=', $id)
    		->get();

    	return \View::make('topicShow')->with('result', $result);
    }

    public function subscribe(){
        
    }

}
