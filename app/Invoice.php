<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    public function customer(){
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function period(){
        return $this->belongsTo('App\Period', 'payment_period');
    }

    public function parcels(){
        return $this->hasMany('App\InvoiceParcel', 'invoice_id');
    }
}
