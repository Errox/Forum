<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CsvController extends Controller
{
    public function index(){

    	return view('csv');
    }

    protected function store(array $data)
    {

    	var_dump($data);
        
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => bcrypt($data['password']),
        // ]);
    	
    }
}
