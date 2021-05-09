<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUser;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::post('/login', 'Auth\LoginController@login')->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

    Route::get('/home', 'HomeController@index');
    //Route::get('/', 'HomeController@index');
    Route::get('/', 'HomeController@dashboard')->name('dashboard');
    Route::get('checkout', 'HomeController@checkout');
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    // <---------------------- Employee Module ----------------->

    Route::middleware([CheckUSer::class])->group(function () {
        
        // ------------------------ Employee ------------------------
        Route::get('/employees', 'UserController@index')->name('employees');
        Route::get('/create-employee', 'UserController@create')->name('create-employee');
        Route::post('/add-employee', 'UserController@store')->name('add-employee');
        Route::get('/edit-employee/{id}', 'UserController@edit')->name('edit-employee');
        Route::post('/update-employee/{id}', 'UserController@update')->name('update-employee');
        
        // <---------------------- Customer ---------------------------
        Route::get('/customers', 'CustomerController@index')->name('customers');
        Route::get('/create-customer', 'CustomerController@create')->name('create-customer');
        Route::post('/add-customer', 'CustomerController@store')->name('add-customer');
        Route::get('/edit-customer/{id}', 'CustomerController@edit')->name('edit-customer');
        Route::post('/update-customer/{id}', 'CustomerController@update')->name('update-customer');
        Route::get('/view-customer/{id}', 'CustomerController@show')->name('view-customer');
        Route::get('/changeStatus', 'CustomerController@changeStatus')->name('changeCustomerStatus');
    });

    // ----------------------- Miscellaneous -----------------------
    // ----------------------- City -------------------------------
    Route::get('/cities', 'CityController@index')->name('cities');
    Route::get('/create-city', 'CityController@create')->name('create-city');
    Route::post('/add-city', 'CityController@store')->name('add-city');
    Route::get('/edit-city/{id}', 'CityController@edit')->name('edit-city');
    Route::post('/update-city/{id}', 'CityController@update')->name('update-city');

    // ----------------------- Add Weight -------------------------
    Route::get('/weights', 'WeightRangeController@index')->name('weights');
    Route::get('/create-weight', 'WeightRangeController@create')->name('create-weight');
    Route::post('/add-weight', 'WeightRangeController@store')->name('add-weight');
    Route::get('/edit-weight/{id}', 'WeightRangeController@edit')->name('edit-weight');
    Route::post('/update-weight/{id}', 'WeightRangeController@update')->name('update-weight');
    Route::get('/view-cities', 'WeightRangeController@getCities')->name('view-cities');

    Route::middleware([CheckUSer::class])->group(function () {
        // ----------------------- Customer Wallet ----------------------
        Route::get('/customer-wallet', 'CustomerWalletController@index')->name('customer-wallet');
        Route::get('/create-customer-wallet', 'CustomerWalletController@create')->name('create-customer-wallet');
        Route::post('/add-customer-wallet', 'CustomerWalletController@store')->name('add-customer-wallet');
        Route::get('/view-customer-wallet/{id}', 'CustomerWalletController@show')->name('view-customer-wallet');
        Route::get('/getWallet', 'CustomerWalletController@getWallet')->name('getWallet');

        // ------------------------- Shipping Module ------------------
        // ------------------------- Add Shipping ---------------------
        Route::get('/shipping-partners', 'ShippingPartnerController@index')->name('shipping-partners');
        Route::get('/create-shipping-partner', 'ShippingPartnerController@create')->name('create-shipping-partner');
        Route::post('/add-shipping-partner', 'ShippingPartnerController@store')->name('add-shipping-partner');
        Route::get('/edit-shipping-partner/{id}', 'ShippingPartnerController@edit')->name('edit-shipping-partner');
        Route::post('/update-shipping-part0ner/{id}', 'ShippingPartnerController@update')->name('update-shipping-partner');
    });

    // -------------------------- Parcel Module --------------------
    // -------------------------- Parcels --------------------------
    Route::get('/parcels', 'ParcelController@index')->name('parcels');
    Route::get('/create-parcel', 'ParcelController@create')->name('create-parcel');
    Route::post('/add-parcel', 'ParcelController@store')->name('add-parcel');
    Route::get('/edit-parcel/{id}', 'ParcelController@edit')->name('edit-parcel');
    Route::get('/print-parcel/{id}', 'ParcelController@print')->name('print-parcel');
    //print_multiple_invoice
    Route::get('/print_multiple_invoice/{array}', 'ParcelController@print_multiple_invoice')->name('print_multiple_invoice');
    //
    Route::post('/update-parcel/{id}', 'ParcelController@update')->name('update-parcel');
    Route::get('/view-parcel/{id}', 'ParcelController@show')->name('view-parcel');
    Route::get('/export', 'ParcelController@export')->name('export');
    Route::post('/import', 'ParcelController@import')->name('import');
    Route::post('/city-change-parcel-book', 'ParcelController@cityChangeParcelBook')->name('city-change-parcel-book');
    Route::get('/change-status', 'ParcelController@changeStatus')->name('change-status');
    Route::post('/validate-parcel', 'ParcelController@validateParcel')->name('validate-parcel');
    Route::get('/barcode', 'ParcelController@barcode')->name('barcode');
    Route::post('/export-parcel-data', 'ParcelController@exportParcelDateWise')->name('export-parcel-data');
    //Route::get('/export-parcel-data-test', 'ParcelController@exportParcelDateWise')->name('export-parcel-data-test');

    //load sheet
    Route::get('/load-sheet', 'LoadSheetController@index')->name('load-sheet');
    Route::get('/create-load-sheet', 'LoadSheetController@create')->name('create-load-sheet');
    Route::get('/add-load-sheet', 'LoadSheetController@store')->name('add-load-sheet');
    Route::get('/view-load-sheet/{id}', 'LoadSheetController@view')->name('view-load-sheet');
    Route::get('/print-load-sheet/{id}', 'LoadSheetController@print')->name('print-load-sheet');    //pdf
    Route::post('/scan-load-sheet-parcel', 'LoadSheetController@scanParcel')->name('scan-load-sheet-parcel');
    
    Route::middleware([CheckUSer::class])->group(function () { 

        Route::get('/return-parcels', 'ParcelController@returnParcel')->name('return-parcels');
        Route::post('/parcel-return', 'ParcelController@parcelReturn')->name('parcel-return');

        // -------------------------- Parcel Status --------------------
        Route::get('/parcel-statuses', 'ParcelStatusController@index')->name('parcel-statuses');
        Route::get('/create-parcel-status', 'ParcelStatusController@create')->name('create-parcel-status');
        Route::post('/add-parcel-status', 'ParcelStatusController@store')->name('add-parcel-status');
        Route::get('/edit-parcel-status/{id}', 'ParcelStatusController@edit')->name('edit-parcel-status');
        Route::post('/update-parcel-status/{id}', 'ParcelStatusController@update')->name('update-parcel-status');

        Route::get('/update-parcel-status-via-tcs-no', 'UpdateStatusController@index')->name('update-parcel-status-via-tcs-no');
        Route::post('/import-parcel-status', 'UpdateStatusController@import')->name('import-parcel-status');
        Route::get('/export-parcel-status', 'UpdateStatusController@export')->name('export-parcel-status');

        // --------------------------- Validate Parcel -----------------
        Route::get('/validate-parcel', 'ValidateParcelController@index')->name('validate-parcel');

        // -------------------------- Payment Module -------------------
        // -------------------------- Payment Method -------------------
        Route::get('/payment-methods', 'PaymentMethodController@index')->name('payment-methods');
        Route::get('/create-payment-method', 'PaymentMethodController@create')->name('create-payment-method');
        Route::post('/add-payment-method', 'PaymentMethodController@store')->name('add-payment-method');
        Route::get('/edit-payment-methods/{id}', 'PaymentMethodController@edit')->name('edit-payment-method');
        Route::post('/update-payment-methods/{id}', 'PaymentMethodController@update')->name('update-payment-method');
        Route::get('getData', 'PaymentMethodController@getData');

        // ------------------------- Invoices Module ---------------------
        // ------------------------- Invoice -----------------------------
        Route::get('/invoices', 'InvoiceController@index')->name('invoices');
        Route::get('/create-invoice', 'InvoiceController@create')->name('create-invoice');
        Route::post('/add-invoice', 'InvoiceController@store')->name('add-invoice');
        Route::get('/edit-invoice/{id}', 'InvoiceController@edit')->name('edit-invoice');
        Route::post('/update-invoice/{id}', 'InvoiceController@update')->name('update-invoice');
        Route::get('/view-invoice/{id}', 'InvoiceController@show')->name('view-invoice');
        Route::get('/post-invoice', 'InvoiceController@postInvoice')->name('post-invoice');
        Route::get('/print-invoice/{id}', 'InvoiceController@printInvoice')->name('print-invoice');

        Route::get('/excel-invoice/{id}', 'InvoiceController@excelInvoice')->name('excel-invoice');

    });
	
	Route::get('/add-bank-details', 'BankController@addBankDetails')->name('add-bank-details');
    Route::post('/save-bank-details','BankController@saveBankDetails')->name('save-bank-details');
    Route::get('/view-bank-details/{id}', 'BankController@view_bank_details')->name('view-bank-details');
    Route::get('/edit-bank-details/{id}', 'BankController@edit_bank_details')->name('edit-bank-details');
    Route::post('/update-bank-details', 'BankController@update_bank_details')->name('update-bank-details');  
	Route::get('/update_notification', 'CustomerController@update_notification')->name('update_notification');
	Route::get('/change-passwords', 'CustomerController@change_passwords')->name('change-passwords');
    Route::post('/user-change-password', 'CustomerController@user_change_password')->name('user-change-password');
	 Route::get('/news-alerts', 'CustomerController@news_alerts')->name('news-alerts');  
    Route::post('/add-news-alerts', 'CustomerController@add_news_alerts')->name('add-news-alerts');
    Route::get('/change_status', 'CustomerController@change_status')->name('change_status');
     Route::get('/view-news-details/{id}', 'CustomerController@view_news_details')->name('view-news-details');
    Route::get('/edit-news-alert/{id}', 'CustomerController@edit_news_alert')->name('edit-news-alert');
    Route::post('/update-news-alert', 'CustomerController@update_news_alert')->name('update-news-alert');
	Route::post('/export-customer-data', 'CustomerController@export_customer_data')->name('export-customer-data');
	Route::get('/tcs-tracking', 'CustomerController@tcs_tracking')->name('tcs-tracking');
	Route::get('/search-tcs-tracking', 'CustomerController@search_tcs_tracking')->name('search-tcs-tracking');
	Route::get('/view-load-sheet', 'LoadSheetController@view_load_sheet')->name('view-load-sheet');
	Route::get('/load-sheet-process', 'LoadSheetController@load_sheet_process')->name('load-sheet-process');
	Route::get('/print-load-Sheet', 'LoadSheetController@print_load_Sheet')->name('print-load-Sheet');
	Route::get('/load-sheet-summary', 'LoadSheetController@load_sheet_summary')->name('load-sheet-summary');
	Route::get('/filter-load-sheet', 'LoadSheetController@filter_load_sheet')->name('filter-load-sheet');
	Route::get('/filter-parcel-validate', 'ParcelController@filter_parcel_validate')->name('filter-parcel-validate');
	Route::get('/track-validate-parcel', 'ParcelController@track_validate_parcel')->name('track-validate-parcel');
	Route::get('/weight-correction', 'ParcelController@weight_correction')->name('weight-correction');
	Route::get('/filter-weight-correction', 'ParcelController@filter_weight_correction')->name('filter-weight-correction');
	Route::get('/change-weight', 'ParcelController@change_weight')->name('change-weight');
	Route::post('/multi-cities', 'ParcelController@multi_cities')->name('multi-cities');
	Route::get('/export-parcels', 'ParcelController@export_parcelsss')->name('export-parcels'); 
	
});       
Route::get('/mypdfs/{id}', 'CustomerController@mypdf');
Route::get('/clear-cache-all', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    return "Cache is cleared";
});