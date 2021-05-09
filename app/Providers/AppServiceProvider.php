<?php

namespace App\Providers;

use Auth;
use App\Customer;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View()->composer('*', function ($view){
            if(Auth::user()['role_id'] == 1){
                $not = Customer::where('user_id', Auth::user()->id)->first();
                if(date('m-d') == substr($not->birth_date, 5)){
                    $notification = "Wish You A Happy Birthday";
                    $view->with(['notification' => $notification]);
                }
                else if(date('m-d') == substr($not->anniversary_date, 5)){
                    $notification = "Wish You A Happy Marriage Anniversary";
                    $view->with(['notification' => $notification]);
                } else {
                    $notification = null;
                    $view->with(['notification' => $notification]);
                }
            } else {
                $notification = null;
                $view->with(['notification' => $notification]);
            }
        });
    }
}
