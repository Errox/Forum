<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

Use App\User;

class ProfileController extends Controller
{
    public function index($id){


    }

    public function show($id){
   $profile = User::where('id', '=', $id)->get();
   return view('profile')->with('profile', $profile);
    }

}
