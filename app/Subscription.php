<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public function index(){
    return $this->belongsTo('App\User', 'App\Topic'); 	
    }
}
