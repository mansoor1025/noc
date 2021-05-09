<?php

namespace App\Http\Controllers;
use App\Parcel;
use App\ParcelStatus;
use Illuminate\Http\Request;

class ValidateParcelController extends Controller
{
    public function index(){
        return view('parcel-module.validate-parcel.validate');
    }
}
