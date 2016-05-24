<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Queue extends Model
{
    public function user(){
		return $this->belongsTo('App\User');
	}

	public function tag(){
		return $this->belongsToMany('App\Tag','tag_queue', 'queue_id', 'tag_id');
	}

	public function teacher(){
		return $this->belongsTo('App\User');
	}

	public function createdAtCarbon($value){
		$this->attributes['created_at'] = diffForHumans($value);
	}
}
