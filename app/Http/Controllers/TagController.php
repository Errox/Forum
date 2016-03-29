<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Tag;

use Request;

class TagController extends Controller
{

	public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

		$result = Tag::all();

        return view('tags')->with('result', $result);

    }

    public function store(){
    	$input = Request::all();

        $tag = new Tag;

        $tag->tag_name = $input['title'];
        
       	$tag->save();

       	return redirect('tag');
    }


}