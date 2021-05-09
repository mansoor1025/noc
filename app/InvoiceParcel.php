<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceParcel extends Model
{
    protected $guarded = [];

    public function parcel(){
        return $this->belongsTo('App\Parcel', 'parcel_id');
    }
}
