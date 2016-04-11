<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;

use App\User;

use Request;

use App\Http\Requests;

class CsvController extends Controller
{
    public function index(){

    	return view('csv');
    }

    protected function store()
    {
      	$input = request::all();
      	$loop = 0;
      
		$input = fopen($_FILES['csv']['tmp_name'], 'r+');
		$lines = array();
		
		while( ($row = fgetcsv($input, 8192)) !== FALSE ) {
			$lines[] = $row;
			$loop += 1;
		
		}
		array_shift($lines);

		for($i=0;$i <= count($lines)-1; $i++) {
			User::create([
	            'name' => $lines[$i]['0'],
	            'email' => $lines[$i]['1'],
	            'password' => bcrypt($lines[$i]['2']),
	        ]);

      	}
      	
      	$good = true;
      	return view('/csv')->with('good', $good);
    }
}
