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
         $result = DB::table('topics')
            ->leftJoin('users', 'topics.user_id', '=', 'users.id')
            ->select('topics.topic_title','topics.id','topics.topic_description','users.name','topics.created_at')
            ->orderBy('created_at', 'desc')
            ->get();
        return \View::make('topics')->with('result', $result);
    }

    public function create()
    {
        $tags = DB::table('tags')
            ->select('tag_name', 'id')
            ->get();

    	return view('create_topic')->with('tags', $tags);
    }

    public function store()
    {
    	$input = Request::all();
            if (isset($input['tags'])){
                $checked = $input['tags'];
            }
            if (empty($checked)){
                return redirect('/topic/create')->with('error', ['foutmelding']);
            }
            else{
                
                $user = \Auth::user();
                $userid = $user->id;

                DB::table('topics')->insert([
                   ['user_id' => $userid, 'topic_title' => $input['title'], 'topic_description' => $input['description']]
                ]);

                $last = DB::table('topics')->orderBy('id', 'desc')->first();
                    foreach ($checked as $check){
                        DB::table('tags_topic')->insert([
                        ['topic_id' => $last->id, 'tag_id' => $check[0]]]);
                    }
            	return redirect('/topic');
            }
    }

    public function show($id){
        //Specific topic/username
            $user = \Auth::user();
            $userid = $user->id;

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

        $result[2] = DB::table('subscription')
            ->select('user_id', 'topic_id')
            ->where('topic_id', '=', $id) 
            ->where('user_id', '=', $userid)
            ->get();

    	return \View::make('topicShow')->with('result', $result);
    }


}
