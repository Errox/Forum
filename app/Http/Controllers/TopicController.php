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

use App\tag_topic;



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
        return view('topic/topics')->with('result', $result);
    }

    public function create()
    {
        if (Auth::check()){
            $tags = Tag::all();
            return view('topic/topicCreate')->with('tags', $tags);
        }
        else{
            return redirect('/topic');
        }
    }

    public function store(Request $request)
    {
        $user = \Auth::user();
        $userid = $user->id;
        $tags = Tag::all();
        $input = $request->all();

        $topic = new Topic;

        $topic->user_id = $userid;
        $topic->topic_title = $input['topic_title'];
        $topic->topic_description =  nl2br($input['topic_description']);
        

        $new_title = $input['topic_title'];
        $new_description = $input['topic_description'];
        $error = 'foutmelding';

        if (isset($input['tags'])){
            $checked = $input['tags'];
        }
        if (empty($checked)){
            return view('topic/create_topic')->with(compact( 'new_title','error', 'new_description', 'tags'));
        }else{
          $topic->save();
          app('App\Http\Controllers\SubscriptionController')->store();
          //Tags moeten nog opgeslagen worden via de tendant table
          $topic->tag()->sync($input['tags']);
          return redirect('topic');
        }
    }

    public function update(Request $request, $id){
      if (Auth::check()){
        $tags = Tag::all();
        $input = $request->all();
        $user = \Auth::user();
        $userid = $user->id; 
        $topic = Topic::find($id);  
        $topic->topic_description =  nl2br($request->input('description'));
        $topic->topic_title = $request->input('title');
        
        if(isset($input['new_tags'])){
            $checked = $input['new_tags'];
        }

        if (empty($checked)){
          $result = $topic;
          //dd($input['new_tags']);
          $error = 'foutmelding';
          return view('topic/topicEdit')->with(compact( 'result','error', 'tags', 'user'));
        }
        else{
        
          $topic->save();
          $tags = tag_topic::where('topic_id','=',$id)->delete();
          $next = 0;
          foreach($input['new_tags'] as $loop){
            $tags = new tag_topic;
            $tags->topic_id = $id;
            $tags->tag_id = $loop;
            $tags->save();
          }
          if ($request->input('notify')){
            $target = "";
            app('App\Http\Controllers\NotificationController')->subnotify($id, $userid, $target);  
          }
        }
       return redirect('/topic/'.$id);
      }
    }

    public function edit($id){
        if (Auth::check()){
          $user = \Auth::user();
          $userid = $user->id;   
          $result = Topic::find($id);
          $tags = Tag::all();
          $user =   User::find($userid);
        }
        
        if ($userid == $result->user_id || $user->role == 1){  
          return view('topic/topicEdit')->with(compact('result', 'user', 'tags', 'input', 'input_name'));
        }
        
        return redirect('topic/'.$id);
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
    	
      return view('topic/topicShow')->with('result', $result);
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
