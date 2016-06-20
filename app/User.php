<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'ov_number', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //een gebruiker heeft voorkeuren van zijn profiel aanpassen. Dit wordt gemakkelijker met deze functie 
    public function privacies(){
        return $this->hasOne('App\User_privacy');
    }

    public function queueComment(){
        return $this->hasMany('App\queue_comment');
    }

    public function queueCommentCount(){
        return $this->queueComment()
         ->selectRaw('user_id, count(*) as aggregate')
         ->groupBy('user_id');
    }
}
