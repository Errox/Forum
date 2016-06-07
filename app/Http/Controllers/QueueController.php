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
        $behandelen = Queue::where('user_id', '=', $userid)
                            ->where('active', '=', 1)->get();
        if (!empty($behandelen[0])){
        $behandelen = $behandelen[0];
    }

    	$tags = Tag::all();
    	return view('queue')->with(compact('queues','tags','user', 'behandelen'));
    }
	//Als dit niet meer werkt voor gods reden, verrander update naar show
    public function show($id){
        $queue = Queue::find($id);
        if ($queue->status != 1){
        $queue->status = 1;
    }
        else{
        $queue->active = 0;    
        }
        $queue->save();
    }

    public function edit($id){
       $result = Queue::where('user_id', '=', $id)
                        ->where('active', '=', 1)
                        ->get();             
        if ($result){
            foreach($result as $found){
            $found->active = 0;
            $found->save();
        }
        }
    }

    public function actief(){
        if (Auth::check()){
            $user = \Auth::user();
            $userid = $user->id; 
            }          
        $result = Queue::where('user_id', '=', $userid)
                            ->where('active', '=', 1)
                            ->get();
       return $result;                     
    }

    public function ajax(){
		$queues = Queue::with('user', 'tag', 'teacher')->where('active', '1')->orderBy('created_at', 'asc')->get();
        if (Auth::check()){
            $user = \Auth::user();
            $userid = $user->id; 
            $role = $user->role;
            }    
    	return compact('queues', 'userid','role');
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
        $tags[] = $input['tag1'];
        
        if($input['tag2'] != 'null'){
            $tags[] = $input['tag2'];
        }
		
        $queue->tag()->sync($tags);

      

	}
}
