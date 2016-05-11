<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

//use App\EventModel;

use App\Room;

use Carbon\Carbon;

use Auth;

use Session;

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
        // Session::flash('flash_message_succes', 'Dit is een flash message');
        if(Auth::check()){
            $user = \Auth::user();
            $userid = $user->id;
        }
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

        $calendar = \Calendar::addEvents($events)
            ->setOptions([ //set fullcalendar options
                'weekends' => false
        ]);
        return view('event')->with(compact('calendar'));
    }



    public function create()
    {
        if (Auth::check()){
            $rooms = Room::all();
            return view('eventCreate')->with('rooms', $rooms);
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

        $date = explode("/", $input['time_0']);
        $date = $date['2'].'-'.$date['0'].'-'.$date['1'];

        $timestart = $date.' '.$input['time_1'].':00';
        $timestop = $date.' '.$input['time_2'].':00';

        $event = new Event;


        $event->user_id = $userid;
        $event->title = $input['description'];
        $event->room_id = $input['room'];
        $event->start_time = $timestart;
        $event->end_time = $timestop;
        $event->save();

        return redirect('/event');
    }
}
