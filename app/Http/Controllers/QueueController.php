<?php

// Dit is wat er allemaal aangeroepen word voor deze controller.

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;

use App\Queue; 

use App\Tag;

use App\User;

use App\queue_comment;

use Auth;

class QueueController extends Controller
{   // In de construct staat alles wat ingeladen word als de controller aangeroepen word.
	public function __construct()
    {
        $this->middleware('auth');
        Carbon::setLocale('nl');
    }
    // In de Index staat alles wat gebruikt word op de pagina en stuurt je door naar de pagina.
public function index(){
        // Hier word gekeken of er iemand ingelogd is en worden de gegevens van de gebruiker opgehaald
        if (Auth::check()){
            $user = \Auth::user();
            $userid = $user->id; 
        } 

        $teachers = user::where('role', '=', '1')->get();


        // $queues haalt alle openstaande queues op          
    	$queues = Queue::where('active', '1')->get();

        // $behandelen haalt alle queues op die door de ingelogde gebruiker gemaakt zijn & openstaand zijn.
        $behandelen = Queue::where('user_id', '=', $userid)
                            ->where('active', '=', 1)->get();
        if (!empty($behandelen[0])){
            $behandelen = $behandelen[0];
        }
        // Hier worden alle tags opgehaald die in de database staan.
    	$tags = Tag::all();
    	
        return view('queue')->with(compact('queues','tags','teachers','user', 'behandelen'));
    }

	// Als dit niet meer werkt voor gods reden, verrander update naar show
    // Bij update word een queue gepakt die geüpdatet worden en zet ze in behandeling of sluit ze af.
    public function update($id){
        $queue = Queue::find($id);
        
        if ($queue->status != 1){
            $queue->status = 1;
            $queue->save();


        }
        else{
            $queue->active = 0;
            $queue->save(); 
            $check = 'true';
            return $check;               
        }
        
        
    }
    // Hier word gekeken of de ingelogde user nog andere tickets had die open staan, en sluit de bestaande af.
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
    // Hier worden alle tickets gepakt die nog open staan (in wachtrij / behandeling) en stuurt ze door.
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

    public function postcomment(Request $request){
        if (Auth::check()){
            $user = \Auth::user();
            $userid = $user->id; 
        }
        $comment = New queue_comment;
        $comment->user_id = $userid;
        $comment->teacher_id = $request->teacher;
        $comment->queue_id = $request->id;
        $comment->comment = $request->comment;

        $comment->save();


    }

    // Hier worden alle queues gepakt die bestaan en op actief staan en stuurt ze door.
    // Deze functie word elke 1.5 seconden aangeroepen door ajax om alles te refreshen. 
    public function ajax(){
		$queues = Queue::with('user', 'tag')->where('active', '1')->orderBy('created_at', 'asc')->get();
        if (Auth::check()){
            $user = \Auth::user();
            $userid = $user->id; 
            $role = $user->role;
        }    
    	return compact('queues', 'userid','role');
	}
    // Als er een nieuwe ticket word gemaakt dan word deze functie aangeroepen
	public function store(Request $request){
		if (Auth::check()){
            $user = \Auth::user();
            $userid = $user->id; 
        }
        // Hier worden alle gegevens van ingevulde velden opgehaald.
        $input = $request->all();
        // Hier word een nieuwe queue/ticket aangmaakt en alle nodige gegevens worden ingevuld.
        $queue = New Queue;

        $queue->user_id = $userid;
        $queue->title = $request->title;
        $queue->save();   
        $tags[] = $input['tag1'];
        
        if($input['tag2'] != 'null'){
            $tags[] = $input['tag2'];
        }
		// Nadat er een nieuwe queue is aangemaakt, dan worden automatisch de gelinkte tags gepakt via hun id & relaties in de models.
        $queue->tag()->sync($tags);
	}
}
