<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoadSheet extends Model
{
    protected $guarded = [];

    public function customer(){
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function loadsheet_parcels(){
        return $this->hasMany('App\LoadSheetParcel', 'load_sheet_id')->orderBy('created_at', 'DESC');
    }

}