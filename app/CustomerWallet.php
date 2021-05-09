<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerWallet extends Model
{
    protected $guarded = [];

    public function customer(){
        return $this->belongsTo('App\Customer', 'customer_id');
    }
}
