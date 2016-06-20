<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;

use App\User;

use Request;

use App\Http\Requests;

use App\User_privacy;

class CsvController extends Controller
{
	//Hier wordt de view van csv gereturnd 
    public function index(){

    	return view('beheer/csv');
    }

    //Een protected function om de data van de csv op te slaan
    protected function store()
    {
    	//Hier wordt het csv betand opgehaald
      	$input = request::all();
      	$loop = 0;
      	
      	//csv bestand wordt geopend in php en een array van gemaakt
		$input = fopen($_FILES['csv']['tmp_name'], 'r+');
		$lines = array();
		
		//Het csv bestand wordt hier in een array geplaatst
		while( ($row = fgetcsv($input, 8192)) !== FALSE ) {
			$lines[] = $row;
			$loop += 1;
		
		}
		array_shift($lines);

		//Hier wordt er geloopt door de array om het in de database op te slaan.
		for($i=0;$i <= count($lines)-1; $i++) {
			$user = User::create([
	            'name' => $lines[$i]['0'],
	            'ov_number' => $lines[$i]['1'],
	            'email' => $lines[$i]['1'].'@mydavinci.nl',
	            'password' => bcrypt($lines[$i]['2']),
	        ]);
	        $priv = new User_privacy;
			
			$user->save();


			$priv->user_id = $user->id;
        	$priv->save();

      	}
      	
      	//wanneer het succesvol was wordt de view gereturnd.
      	$good = true;
      	return view('beheer/csv')->with('good', $good);
    }
}
