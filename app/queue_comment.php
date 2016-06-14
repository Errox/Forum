<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class queue_comment extends Model
{
    public function teacher(){
    	return $this->belongsTo('App\User');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
