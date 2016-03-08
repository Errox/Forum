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
         // $topics = DB::table('topics')
        //     ->leftJoin('users', 'topics.user_id', '=', 'users.id')
        //     ->select('topics.topic_title','topics.topic_description','users.name','topics.created_at')
        //     ->get();
        //     var_dump(get_defined_vars());
        //     echo $topics[1]->name;
        // fix om user name bij de topic view page te krijgen. error topic doesnt work.

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
        //Specific topic/username
    	$result[0] = DB::table('topics')
    		->leftJoin('users', 'topics.user_id', '=', 'users.id')
    		->select('topics.id','users.name','topics.topic_title','topics.topic_description', 'topics.created_at')
    		->where('topics.id', '=', $id)
    		->get();

        $result[1] = DB::table('topics')
            ->leftJoin('comments', 'topics.id', '=', 'comments.topic_id')
            ->leftJoin('users', 'comments.user_id', '=', 'users.id')
            ->select('users.name', 'comments.topic_id', 'comments.comment_description', 'comments.created_at')
            ->where('comments.topic_id', '=', $id)
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
