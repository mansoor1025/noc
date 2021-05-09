<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParcelLog extends Model
{
    protected $guarded = [];

    public function status(){
        return $this->belongsTo('App\ParcelStatus', 'parcel_status_id');
    }

}
