<?php

namespace App\Http\Controllers;

use Auth;

use Request;

use App\Http\Requests;

use App\Topic;

use App\Tag;

use App\Comment;

use App\Subscription;

class TopicController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.	
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            $user = \Auth::user();
            $result[4] = $user->id;
        }

        $result[0] = Topic::orderBy('created_at', 'desc')->get();
        $result[2] = Topic::with('subscriptions')->get()->sortBy(function($topic){
            return $topic->subscriptions->count();
        },$options = SORT_REGULAR, $descending = true );
        $result[3] = Subscription::all();
       // dd($result[5]);
        return view('topics')->with('result', $result);
    }

    public function create()
    {
        if (Auth::check()){
            
            $tags = Tag::all();
        	
            return view('create_topic')->with('tags', $tags);
        }
        else{

            return redirect('/topic');
        
        }
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
        
        if (isset($input['tags'])){
            $checked = $input['tags'];
        }
        if (empty($checked)){
            return redirect('/topic/create')->with('error', ['foutmelding']);
        }else{
          $topic->save();

        //Tags moeten nog opgeslagen worden via de tendant table
        $topic->tag()->sync($input['tags']);
        return redirect('topic');
        }
    }
    public function show($id){
        $result[0] = Topic::where('id', '=', $id)
        ->with('tag')
        ->get();

        $result[1] = Comment::where('topic_id', '=', $id)->get();

        if (Auth::check()){
            $user = \Auth::user();
            $userid = $user->id;

            $result[2] = Subscription::where('user_id', '=', $userid)
                                      ->where('topic_id', '=', $id)
                                      ->get();         
        }
    	return view('topicShow')->with('result', $result);
    }


}
