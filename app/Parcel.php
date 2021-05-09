<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    protected $guarded = [];

    public function customer(){
        return $this->belongsTo('App\Customer', 'customer_id');
    }
    public function status(){
        return $this->belongsTo('App\ParcelStatus', 'parcel_status_id');
    }
    public function partner(){
        return $this->belongsTo('App\ShippingPartner', 'shipping_partner_id');
    }

    public function statuslog(){
        return $this->hasMany('App\ParcelLog', 'parcel_id');
    }

}
