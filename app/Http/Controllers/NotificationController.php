<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use App\Notification;

class NotificationController extends Controller
{
    public function notification($id){
    	Notification::where('receiver_id', '=', $id);

    }
}
