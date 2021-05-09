<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Parcel;
use App\Customer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function dashboard()
    {   
        //
        $u_id = Auth::user()->id;
        $customer = Customer::where('user_id', $u_id)->first();
       
        $role_id = User::where('id', $u_id)->first()->role_id;
        //

        if($role_id==1){
            $total_parcels = Parcel::count();
            $total_returns = Parcel::where('parcel_status_id', 5)->count();
            $total_returns_karachi = Parcel::where('parcel_status_id', 5)->where('destination_city', 'Karachi')->count();
            $total_returns_lahore = Parcel::where('parcel_status_id', 5)->where('destination_city', 'Lahore')->count();
        }else{
            $total_parcels = Parcel::where('customer_id', $u_id)->count(); 
			
            $total_returns = Parcel::where('parcel_status_id', 5)->where('customer_id', $u_id)->count();
            $total_returns_karachi = Parcel::where('parcel_status_id', 5)->where('customer_id', $u_id)->where('destination_city', 'Karachi')->count();
            $total_returns_lahore = Parcel::where('parcel_status_id', 5)->where('customer_id', $u_id)->where('destination_city', 'Lahore')->count();
        }
		
		
        return view('dashboard', compact('total_parcels', 'total_returns', 'total_returns_karachi', 'total_returns_lahore'));
    }

    public function index()
    {
		
        //return 'here';
        try {
            $check = Attendance::where('user_id', Auth::user()->id)->whereDate('check_in', date('Y-m-d'))->first();
            
            if(Auth::user()->role_id == 2 && $check == null){
                DB::beginTransaction();
                Attendance::create([
                    'user_id'  => Auth::user()->id,
                    'check_in' => Carbon::now('Asia/Karachi')->toDateTimeString()
                ]);
                DB::commit();
            } 
			else{
			 $total_parcels = Parcel::where('customer_id', Auth::user()->id)->count();
			 $total_returns = Parcel::where('parcel_status_id', 5)->where('customer_id', Auth::user()->id)->count();
			 $total_returns_karachi = Parcel::where('parcel_status_id', 5)->where('customer_id', Auth::user()->id)->where('destination_city', 'Karachi')->count();
			 $total_returns_lahore = Parcel::where('parcel_status_id', 5)->where('customer_id', Auth::user()->id)->where('destination_city', 'Lahore')->count();	 	
             return view('dashboard',compact('total_parcels','total_returns','total_returns_karachi','total_returns_lahore'));
			}
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    public function checkout(){
        try {
            $check_in = Attendance::where('user_id', Auth::user()->id)->whereDate('check_in', date('Y-m-d'))->first();
            $check_out = Attendance::where('user_id', Auth::user()->id)->whereDate('check_out', date('Y-m-d'))->first();

            $current_time = Carbon::now('Asia/Karachi')->toDateTimeString();
            $check_in_time  = Carbon::parse($check_in->check_in);
            $check_out_time = Carbon::parse($current_time);
            $duration = $check_out_time->diff($check_in_time)->format('%H:%I:%S');

            if(Auth::user()->role_id == 2 && $check_out == null){
                DB::beginTransaction();
                Attendance::where('user_id', Auth::user()->id)->whereDate('check_in', date('Y-m-d'))->update([
                    'check_in'  => $check_in->check_in,
                    'check_out' => $current_time,
                    'durations' => $duration
                ]);
                DB::commit();
                return view('dashboard')->with('message', 'Checkout Successfully');
            } else {
                return redirect()->back()->with('error', 'Already Checked out');
            }
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }
}
