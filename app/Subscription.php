<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
	public function user(){
		return $this->belongsTo('App\User');
	}

	public function topic(){
		return $this->belongsTo('App\Topics');
	}
}
