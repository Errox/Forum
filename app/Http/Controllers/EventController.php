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
        // Checken of gebruiker wel is ingelogd
        if(Auth::check()){
            $user = \Auth::user();
            $userid = $user->id;
        }

        //Events array vullen met events.
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

        //Calender opbouwen.
        $calendar = \Calendar::addEvents($events)
            ->setOptions([ //set fullcalendar options
                'weekends' => false
        ]);
        return view('event/event')->with(compact('calendar','user'));
    }


    // Dit is de functie om een event aan te maken
    public function create()
    {
        //checken of gebruiker is ingelogd.
        if (Auth::check()){
            $user = \Auth::user();
            if($user->role == 0){
                return redirect('/topic');
            }
            $rooms = Room::all();
            Session::flash('flash_message_alert', 'Let op! Een afspraak wordt niet laten zien in het weekend.');
            return view('event/eventCreate')->with('rooms', $rooms);
        }
        else{
            return redirect('event/event');
        }
    }

    //Opslaan function
    public function store(Request $request)
    {
        //checken voor gebruiker id en ophalen van alle requests
        $user = \Auth::user();
        $userid = $user->id;
        $input = $request->all();

        //Datum naar correcte string converten.
        $date = explode("-", $input['time_0']);
        $date = $date['2'].'-'.$date['1'].'-'.$date['0'];

        $timestart = $date.' '.$input['time_1'].':00';
        $timestop = $date.' '.$input['time_2'].':00';

        //Niewu event aanmaken en de goeie velden vullen
        $event = new Event;

        $event->user_id = $userid;
        $event->title = $input['description'];
        $event->room_id = $input['room'];
        $event->start_time = $timestart;
        $event->end_time = $timestop;
        $event->save();

        return redirect('event/event');
    }
}
