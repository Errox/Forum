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

    //Index voor all tags
    public function index(){

	   	$result = Tag::all();

      return view('beheer/tags')->with('result', $result);

    }

    //opslaan van alle tags
    public function store(){
  	  $input = Request::all();

      //nieuwe tag wordt aangevraagd en velden worden gevuld.
      $tag = new Tag;

      $tag->tag_name = $input['title'];
      
     	$tag->save();

     	return redirect('tag');
    }

    //het verwijderen/Archiveren van een tag
    public function destroy($id){
      $input = Request::all();

      //als de tag active is wordt het inactief gemaakt en als het inactief is wordt het actief gemaakt.
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