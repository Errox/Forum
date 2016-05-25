<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;

use App\Queue; 

use App\Tag;

use Auth;

class QueueController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
        Carbon::setLocale('nl');
    }

    public function index(){
        if (Auth::check()){
            $user = \Auth::user();
            $userid = $user->id; 
            }        
    	$queues = Queue::where('active', '1')->get();
    	$tags = Tag::all();
    	return view('queue')->with(compact('queues','tags','user'));
    }

    public function update($id){
        $queue = Queue::find($id);
        if ($queue->status != 1){
        $queue->status = 1;
    }
        else{
        $queue->active = 0;    
        }
        $queue->save();
    }

    public function ajax(){
		$queues = Queue::with('user', 'tag', 'teacher')->where('active', '1')->orderBy('created_at', 'asc')->get();
    	return $queues;
	}

	public function store(Request $request){
		if (Auth::check()){
            $user = \Auth::user();
            $userid = $user->id; 
        }
        $input = $request->all();

        $queue = New Queue;

        $queue->user_id = $userid;
        $queue->title = $request->title;
		
		$queue->save();        

	}
}
