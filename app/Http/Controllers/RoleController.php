<?php

namespace App\Http\Controllers;

use Auth;

use Request;

use App\Http\Requests;

use App\Topic;

use App\Tag;

use App\Comment;

use App\Subscription;

use App\User;

use Carbon\Carbon;


class RoleController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
        Carbon::setLocale('nl');
    }
    
    public function index(){
		$result[0] = Topic::with('user')->with('tag')->with('subscriptions')->get()->sortBy(function($topic){
            return $topic->subscriptions->count();
        },$options = SORT_REGULAR, $descending = true );

    	return view('beheer')->with('result', $result);
    }
}
