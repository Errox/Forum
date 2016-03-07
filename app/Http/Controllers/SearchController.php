<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use View;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$SearchQuery = $_POST['Search'];


    	$result = DB::table('topics')
    		->select('topic_title', 'topic_description', 'id')
    		->where('topic_title', 'like', '%'.$SearchQuery.'%')
    		->get();
    	//$result = \App\Topics::all();
    	return View::make('/home')->with('result', $result);

    		
    }
}
