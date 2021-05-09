<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
	 use Notifiable;
    protected $guarded = [];

    public function role(){
        return $this->belongsTo('App\Role', 'role_id');
    }

    /*public function customer(){
        return $this->belongsTo('App\Customer', 'id', 'user_id');
    }*/
}
