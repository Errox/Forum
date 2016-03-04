<?php

namespace App\Http\Controllers;

use Request;

use Carbon\Carbon;

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

    public function create(){
    	return view('create_topic');
    }

    public function store(){
    	$input = Request::all();
    	$input['published_at'] = Carbon::now();

    	\App\topics::create($input);

    	return redirect('topic');

    }
}
