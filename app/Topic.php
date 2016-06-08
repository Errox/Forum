<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
	//Een topic is gemaakt door een user. Die user kan opgevraagd worden door deze functie
	public function user(){
		return $this->belongsTo('App\User');
	}

	//Een topic kan meerdere tags hebben, Die kunnen met deze functie opgevraagd worden.
	public function tag(){
		return $this->belongsToMany('App\Tag','tag_topics', 'topic_id', 'tag_id');
	}

	//Een topic kan meerdere aanmeldingen hebben van leerlingen. Die kunnen met deze functie opgevraagd worden
	public function subscriptions(){
		return $this->hasMany('App\Subscription');
	}

	//Om het aantal aanmeldingen op een topic te kunnen tellen, wordt het in deze functie berekend hoeveel mensen zich aangemeld hebben. Ook wordt het gelijk op volgorde gezet van meeste aanmeldingen tot minste aanmeldingen.
	public function subscriptionsCount(){
		return $this->subscriptions()
		 ->selectRaw('topic_id, count(*) as aggregate')
		 ->groupBy('topic_id');
	}
}
