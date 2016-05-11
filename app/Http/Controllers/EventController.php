<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

//use App\EventModel;

use Carbon\Carbon;

use Auth;

use App\Event;

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
        $events = [];
            
        $found = Event::all();
        foreach ($found as $found_events){
            $found_events_title = $found_events->room->name .' '. $found_events->title;
            $events[] = \Calendar::event(
                $found_events_title,
                false,
                $found_events->start_time,
                $found_events->end_time,
                $found_events->id
                );

        }
/*/
$events[] = \Calendar::event(
    'Event One', //event title
    false, //full day event?
    '2016-05-15T0800', //start time (you can also use Carbon instead of DateTime)
    '2016-05-15T0900', //end time (you can also use Carbon instead of DateTime)
    0 //optionally, you can specify an event ID
);

$events[] = \Calendar::event(
    "Valentine's Day", //event title
    true, //full day event?
    new \DateTime('2016-05-14'), //start time (you can also use Carbon instead of DateTime)
    new \DateTime('2016-05-14'), //end time (you can also use Carbon instead of DateTime)
    'stringEventId' //optionally, you can specify an event ID
);/*/

//$eloquentEvent = EventModel::first(); //EventModel implements MaddHatter\LaravelFullcalendar\Event

$calendar = \Calendar::addEvents($events)
    ->setOptions([ //set fullcalendar options
        'weekends' => false
    ]);
        return view('event')->with(compact('calendar'));
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
