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

      return view('beheer/tags')->with('result', $result);

    }

    public function store(){
  	  $input = Request::all();

      $tag = new Tag;

      $tag->tag_name = $input['title'];
      
     	$tag->save();

     	return redirect('tag');
    }

    public function destroy($id){
      $input = Request::all();

      $result = Tag::find($id);
        if($result->active == "1"){
          $update = Tag::find($id);
          $update->active = '0';
          $update->save();
        }else{
          $update = Tag::find($id);
          $update->active = '1';
          $update->save();
        }
      return redirect('tag');
    }


}