<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queue_teacher extends Model
{
    public function teacher(){
    	return $this->belongsTo('App\User');
    }

    public function student(){
    	return $this->belongsTo('App\User');
    }
}
