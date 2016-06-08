<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	//Bij een tag hoort een topic. Met deze functie kun je die oproepen.
	public function topic(){
		return $this->belongsTo('App\Topics');
	}

	//Bij een tag kun je aanvragen welke queue tickets er bij horen, dat kan met deze functie
	public function queue(){
		return $this->belongsTo('App\Queues');
	}
}
