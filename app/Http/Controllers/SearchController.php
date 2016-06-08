<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Topic;

use View;

use Auth;

class SearchController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth');
    
    }

    public function index()
    {
        //Dit is de functie om te zoeken naar een topic title.
        //De post wordt hier opgevangen en in searchQuery gestopt.
    	$SearchQuery = $_POST['Search'];
        //Het zoek resultaat wordt nu getrimd op spatsies. 
        $NoSpace = trim($SearchQuery, ' ');
        //Het zoek resultaat wordt nu geteld en door gegeven. 
        $result[0] = strlen($NoSpace);
        //De topic search wordt nu opgevraagd met een search query.
        $result[1] = Topic::where('topic_title', 'like', '%'.$NoSpace.'%')->get();
        //De view wordt gereturnd
    	return View::make('search/search')->with('result', $result);    		
    }
}
