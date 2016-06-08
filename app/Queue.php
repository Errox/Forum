<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Queue extends Model
{
	//Bij een queue ticket hoort een user. Dit kan hiermee opgevraagd worden als queue->user
    public function user(){
		return $this->belongsTo('App\User');
	}

	//bij een queue ticket horen tags. Dit kan hiermee opgevraagd worden.
	public function tag(){
		return $this->belongsToMany('App\Tag','tag_queue', 'queue_id', 'tag_id');
	}

	//Deze functie is gebouwd om de datum in queue (wat in de database staat als bv "20-10-2016 12:50:20" ) wordt het nu laten zien als 5 minuten geleden. 
	public function getCreatedAtAttribute($value){
		$isDate = new Carbon($value);
		return $isDate->diffForHumans();
	}
}
