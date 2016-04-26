<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Topic;

use App\Tag;

use App\Comment;

use App\Subscription;

use Carbon\Carbon;

use App\User;



class TopicController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        Carbon::setLocale('nl');
    }

    /**
     * Show the application dashboard.	
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $result[0] = Topic::orderBy('created_at', 'desc')
            ->where('active', '<>', '0')
            ->get();
        $result[2] = Topic::with('subscriptions')
            ->where('active', '<>', '0')
            ->get()->sortBy(function($topic){
                return $topic->subscriptions->count();
            },$options = SORT_REGULAR, $descending = true );
        $result[3] = Subscription::all();

       // dd($result[5]);

        if(Auth::check()){
            $user = \Auth::user();
            $result[4] = $user->id;
        }
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

    public function store(Request $request)
    {
        $user = \Auth::user();
        $userid = $user->id;

        $input = $request->all();

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

        public function update(Request $request, $id){
           $topic = Topic::find($id);
           $topic->topic_description = $request->input('description');
           $topic->save();

           return redirect('/topic/'.$id);
        }

        public function edit($id){
            $result = Topic::find($id);




        return view('topicEdit')->with(compact('result'));
    }

    public function show($id){
        $result[0] = Topic::with('user')->with('tag')->where('id', '=', $id)->get();

        $result[1] = Comment::where('topic_id', '=', $id)->get();
        $result[2] = Topic::with('user')->get();

        if (Auth::check()){
            $user = \Auth::user();
            $userid = $user->id;

            $result[2] = Subscription::where('user_id', '=', $userid)
                                      ->where('topic_id', '=', $id)
                                      ->get();         
        }
    	return view('topicShow')->with('result', $result);
    }


    public function close(Request $request){
        $user = \Auth::user();
        $userid = $user->id;
        $found = Topic::with('user')
            ->where('id', '=', $request->input('id'))
            ->first();
        if($userid == $found->user_id || $user->role == 1){          
            $found->active = '0';
            $found->save();
            return redirect('/topics');            
        }



    }
}
