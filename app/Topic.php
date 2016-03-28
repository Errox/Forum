<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
	public function user(){
		return $this->belongsTo('App\User');
	}

	public function tag(){
		return $this->hasMany('App\Tag', 'App\Topic', 'topic_id', 'tag_id');
	}

	public function subscriptions(){
		return $this->hasMany('App\Subscription');
	}

	public function subscriptionsCount(){
		return $this->subscriptions()
		 ->selectRaw('topic_id, count(*) as aggregate')
		 ->orderBy('aggregate', 'desc')
		 ->groupBy('topic_id');
	}

}
