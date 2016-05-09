<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function user(){
		return $this->belongsTo('App\User');
	}

	public function receiver(){
		return $this->belongsTo('App\User');
	}

	public function topic(){
		return $this->belongsTo('App\Topic');
	}
}
