<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_privacy extends Model
{
    public function privacies(){
    	return $this->belongsTo('App\User');
    }
}
