<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeightRange extends Model
{
    protected $guarded = [];

    public function customer(){
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function range(){
        return $this->hasMany('App\WeightRangeCityWise', 'range_id');
    }
}
