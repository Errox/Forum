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
        $tags = DB::table('tags')->select('tag_name', 'id')
                                   ->get();



    	return view('create_topic')->with('tags', $tags);
    }

    public function store()
    {
    	$input = Request::all();

    	$user = \Auth::user();
    	$userid = $user->id;


        DB::table('topics')->insert([
            ['user_id' => $userid, 'topic_title' => $input['title'], 'topic_description' => $input['description']]
        ]);

    $last = DB::table('topics')->orderBy('id', 'desc')->first();
        DB::table('tags_topic')->insert([
            ['topic_id' => $last->id, 'tag_id' => $input['tag']]]);



    	return redirect('/home');
    }

    public function show($id){
    	$result = DB::table('topics')
    		->leftJoin('users', 'topics.user_id', '=', 'users.id')
    		->select('topics.id','users.name','topics.topic_title','topics.topic_description')
    		->where('topics.id', '=', $id)
    		->get();

    	return \View::make('topicShow')->with('result', $result);
    }

    public function subscribe(){
        $user = \Auth::user();
        $userid = $user->id;

        DB::table('subscription')->insert([
            ['user_id' => $userid, 'topic_id' => $topic_id]
        ]);


        return redirect('/home/'.$topic_id);
    }

}
