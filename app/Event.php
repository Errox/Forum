<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function user(){
    	return $this->belongsTo('App\user');
    }

    public function room(){
    	return $this->belongsTo('App\Room');
    }
}
