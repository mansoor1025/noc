<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeightRangeCityWise extends Model
{
    protected $guarded = [];

    public function city(){
        return $this->belongsTo('App\City', 'city_id');
    }
}
