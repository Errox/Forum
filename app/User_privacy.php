<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_privacy extends Model
{
	//een gebruiker is gekoppeld met voorkeuren van de user, Dit wordt mogenlijk met deze functie.
    public function privacies(){
    	return $this->belongsTo('App\User');
    }
}
