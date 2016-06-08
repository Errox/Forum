<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	//Elk event is aangemaakt door een user en kan opgevraagd worden door event->user.
    public function user(){
    	return $this->belongsTo('App\user');
    }

    //Elk event heeft een room. De room kan aangevraagd worden door event->room.
    public function room(){
    	return $this->belongsTo('App\Room');
    }
}
