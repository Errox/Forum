<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
	//Bij een aanmelding hoort een gebruiker. Met deze functie is het mogenlijk om die aan te vragen
	public function user(){
		return $this->belongsTo('App\User');
	}

	//Bij een aanmelding van een gebruiker hoort het dat je een topic kan zien waar de gebruiker zich op heeft aangemeld. Met deze functie is het mogenlijk om die aan te vragen
	public function topic(){
		return $this->belongsTo('App\Topics');
	}
}
