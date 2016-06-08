<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	//De user kan aangevraagd worden door comment->user.
    public function user(){
		return $this->belongsTo('App\User');
	}
	//De topic bij de comment kan worden aangevraagd met comment->topic.
	public function topic(){
		return $this->belongsTo('App\Topic');
	}
}
