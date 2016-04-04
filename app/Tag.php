<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	public function topic(){
		return $this->belongsTo('App\Topics');
	}
}
