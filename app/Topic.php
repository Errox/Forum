<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
	public function user(){
		return $this->belongsTo('App\User');
	}

	public function tag(){
		return $this->belongsToMany('App\tag','tag_topics', 'topic_id', 'tag_id');
	}

	public function getTags(){
		return $this->hasMany('App\tag_topic');
	}

	public function subscriptions(){
		return $this->hasMany('App\subscription');
	}

	public function subscriptionsCount(){
		return $this->subscriptions()
		 ->selectRaw('topic_id, count(*) as aggregate')
		 ->groupBy('topic_id');
	}
}
