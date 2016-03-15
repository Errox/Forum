<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\topic;

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

        $NoSpace = trim($SearchQuery, ' ');
        $result[0] = strlen($NoSpace);
        $result[1] = Topic::where('topic_title', 'like', '%'.$NoSpace.'%')->get();

    	return View::make('/home')->with('result', $result);    		
    }
}
