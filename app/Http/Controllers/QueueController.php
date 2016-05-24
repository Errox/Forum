<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;

use App\Queue; 

class QueueController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
        Carbon::setLocale('nl');
    }

    public function index(){
    	$queues = Queue::where('active', '1')->get();

    	return view('queue')->with(compact('queues'));
    }

    public function ajax(){
		$queues = Queue::with('user', 'tag', 'teacher')->where('active', '1')->get();
    	return $queues;
	}
}
