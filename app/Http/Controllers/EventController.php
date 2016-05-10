<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Event;

use Carbon\Carbon;

use Auth;


class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        Carbon::setLocale('nl');
    }

    /**
     * Show the application dashboard.	
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


		$events = Event::all();

        if(Auth::check()){
            $user = \Auth::user();
            $userid = $user->id;
        }
        return view('event')->with(compact('events', 'userid'));
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
        $topic->topic_description =  nl2br($input['description']);
        
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
       if (Auth::check()){
           $user = \Auth::user();
           $userid = $user->id; 
           $topic = Topic::find($id);  
           $topic->topic_description =  nl2br($request->input('description'));
           $topic->save();

           if ($request->input('notify')){
            $target = "";
       app('App\Http\Controllers\NotificationController')->subnotify($id, $userid, $target);  
           }
       }
       return redirect('/topic/'.$id);
    }

    public function edit($id){
        if (Auth::check()){
            $user = \Auth::user();
            $userid = $user->id;   
            $result = Topic::find($id);
            $user =   User::find($userid);
            if ($userid == $result->user_id || $user->role == 1){  
                return view('topicEdit')->with(compact('result'));
            }
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
