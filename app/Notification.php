<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	//Een notificatie wordt verzonden door een user. De verzender kan opgevraagd worden met notification->user
    public function user(){
		return $this->belongsTo('App\User');
	}

	//een notificatie wordt ontvangen door de user. De ontvanger kan opgevraagd worden met notification->reciever
	public function receiver(){
		return $this->belongsTo('App\User');
	}
	//Een notification kan gekoppeld zijn aan een topic verrandering(een comment geplaatst of de topic is aangepast).
	public function topic(){
		return $this->belongsTo('App\Topic');
	}
}
