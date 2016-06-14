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
        'name', 'email', 'password',
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

    public function Queue_teachers(){
        return $this->hasMany('App\Queue_teacher');
    }

    //Om het aantal aanmeldingen op een topic te kunnen tellen, wordt het in deze functie berekend hoeveel mensen zich aangemeld hebben. Ook wordt het gelijk op volgorde gezet van meeste aanmeldingen tot minste aanmeldingen.
    public function Queue_teachersCount(){
        return $this->Queue_teacher()
         ->selectRaw('student_id, count(*) as aggregate')
         ->groupBy('student_id');
    }
}
