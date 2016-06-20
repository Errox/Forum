<?php
// Dit is wat er allemaal aangeroepen word voor deze controller.
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
{   // In de construct staat alles wat ingeladen word als de controller aangeroepen word.
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
    // In de Index staat alles wat gebruikt word op de pagina en stuurt je door naar de pagina.
    public function index()
    {
      // Bij $result[0] worden alle topics opgehaald die niet gesloten zijn.
      $result[0] = Topic::orderBy('created_at', 'desc')
            ->where('active', '<>', '0')
            ->get();

      // Bij $result[2] worden alle topics opgehaald met een gekoppelde subscription      
      $result[2] = Topic::with('subscriptions')
            ->where('active', '<>', '0')
            ->get()->sortBy(function($topic){
                return $topic->subscriptions->count();
            },$options = SORT_REGULAR, $descending = true );

      // Bij $result[3] worden alle bestaanden subscriptions opgehaald.      
      $result[3] = Subscription::all();

      // Hier word er gekeken of er ingelogd is en word het user id gepakt.
      if(Auth::check()){
        $user = \Auth::user();
        $result[4] = $user->id;
      }

        return view('topic/topics')->with('result', $result);
    }
    
    // Hier kom je als je een nieuwe topic aan wilt maken en word doorgestuurt naar de bijbehorende blade.php
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

    // Hier word een topic gemaakt en alle bijbehorende gegevens ingevuld.
    public function store(Request $request)
    { // Hier worden de gegevens opgevraagd van de ingelogde gebruiker 
        $user = \Auth::user();
        $userid = $user->id;
        $tags = Tag::all();
        $input = $request->all();

        $topic = new Topic;
        // Hier word alles verdeeld in de juiste velden en wat de gebruiker ingevuld heeft.
        $topic->user_id = $userid;
        $topic->topic_title = $input['topic_title'];
        $topic->topic_description =  $input['topic_description'];
        
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
          // De subscriptioncontroller functie store word aangeroepen om gelijk de gebruiker te subscriben aan zijn aangemaakte topic.
          app('App\Http\Controllers\SubscriptionController')->store();
          //Tags moeten nog opgeslagen worden via de tendant table
          $topic->tag()->sync($input['tags']);
          return redirect('topic');
        }
    }
    // De update word aangeroepen als er een topic aangepast is en de gegevens moeten geüpdatet worden.
    public function update(Request $request, $id){
      if (Auth::check()){
        $tags = Tag::all();
        $input = $request->all();
        $user = \Auth::user();
        $userid = $user->id; 
        $topic = Topic::find($id);  
        $topic->topic_description =  $request->input('description');
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
          if (Auth::check()){
            // Hier word eerst gekeken of je ingelogd bent en er niet langs probeerd te komen.
            // Alle tags en ingevulde velden worden opgehaald en ingevoerd.
            $tags = Tag::all();
            $input = $request->all();
            $user = \Auth::user();
            $userid = $user->id; 
            $topic = Topic::find($id);  
            $topic->topic_description =  $request->input('description');
            $topic->topic_title = $request->input('title');
            $result = $topic;

            $topic->save();

            $tags = tag_topic::where('topic_id','=',$id)->delete();
            $next = 0;
            // Hier worden alle aangevinkte tags getelt en ieder ingevoerd.  
            foreach($input['new_tags'] as $loop){
              $tags = new tag_topic;
              $tags->topic_id = $id;
              $tags->tag_id = $loop;
              $tags->save();
              
              // Als de checkbox om een notification te sturen in aangevinkt door een docent dan kom je door de if statement heen.
              if ($request->input('notify')){
                $target = "";
                app('App\Http\Controllers\NotificationController')->subnotify($id, $userid, $target);  
              }
            }
            return redirect('/topic/'.$id);
          }
        }
      }
    }
    
    // Hier worden benodigde gegevens opgehaald en doorgestuurd naar de juiste blade.php
    public function edit($id){
      if (Auth::check()){
        $user = \Auth::user();
        $userid = $user->id;   
        $result = Topic::find($id);
        $tags = Tag::all();
        $user =   User::find($userid);
      }

      // Er word nog voor de zekerheid gekeken of je een leeraar bent / de maker van de topic.    
      if ($userid == $result->user_id || $user->role == 1){  
        return view('topic/topicEdit')->with(compact('result', 'user', 'tags', 'input', 'input_name'));
      }  
      return redirect('topic/'.$id);
    }

    // Deze functie word aangeroepen als je een bepaalde topic gaat bekijken.
    public function show($id){
      // Hier worden alle gegevens die nodig zijn voor de pagina opgehaald
      $result[0] = Topic::with('user')->with('tag')->where('id', '=', $id)->get();
      $result[1] = Comment::where('topic_id', '=', $id)->get();
      $result[2] = Topic::with('user')->get();
      if (Auth::check()){
        $user = \Auth::user();
        $userid = $user->id;
        // Hier word nog gekeken of je gesubscribed hebt op de bijbehorende topic
        $result[2] = Subscription::where('user_id', '=', $userid)
              ->where('topic_id', '=', $id)
              ->get();         
      }
      return view('topic/topicShow')->with('result', $result);
    }

    // Deze functie word aangeroepen als een leervraag gesloten word.
    public function close(Request $request){
      $user = \Auth::user();
      $userid = $user->id;
      // Hier word de gebruiker gepakt die de topic aan heeft gemaakt
      $found = Topic::with('user')
          ->where('id', '=', $request->input('id'))
          ->first();
      // Hier word nog voor de zekerheid gekeken of je de maker bent van de topic / een leeraar bent    
      if($userid == $found->user_id || $user->role == 1){         
        // Hier word de topic afgesloten. 
        $found->active = '0';
        $found->save();
        return redirect('/topics');            
      }
    }
}
