<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\topic;

class TopicNLController extends Controller
{
	public function __construct()
    {

    }

    	 public function index()
    {
        $result = Topic::all();
        return \View::make('topics')->with('result', $result);
    }


}
