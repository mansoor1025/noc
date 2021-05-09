<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

/*Route::post('/add-customer1', function (Request $request) {
    return 'test';
});*/

Route::post('/add-customer', 'CustomerController@storeapi')->name('add-customer');
Route::get('/new-add-customer', 'CustomerController@newstoreapi')->name('new-add-customer');
Route::get('/get-cities-name', 'CustomerController@get_cities_name')->name('get-cities-name');
Route::post('/parcel-status', 'ParcelController@parcelStatus')->name('parcel-status');
Route::post('/add-parcel', 'ParcelController@add_parcel')->name('add-parcel');