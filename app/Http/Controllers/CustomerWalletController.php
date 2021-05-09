<?php

namespace App\Http\Controllers;
use DB;
use App\Customer;
use App\CustomerWallet;
use App\CustomerWalletLog;
use Illuminate\Http\Request;

class CustomerWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallets = CustomerWallet::with('customer')->get(); 
        return view('miscellaneous.customer-wallet.customer-wallet', compact('wallets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        return view('miscellaneous.customer-wallet.add', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer' => 'required',
            'amount'   => 'required',
            'type'     => 'required'
        ]);

        try {            
            DB::beginTransaction();
            CustomerWallet::where('id', $request->customer)->decrement('amount', $request->amount);
            
            CustomerWalletLog::create([
                'customer_id' => $request->customer,
                'amount'      => $request->amount,
                'description' => $request->description ?? ''
            ]);

            DB::commit();
            return redirect('customer-wallet')->with('message', 'Your Wallet Updated Successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Something Went Wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomerWallet  $customerWallet
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $wallet = CustomerWallet::where('id', decrypt($id))->first();
            $wallet_log = CustomerWalletLog::where('customer_id', $wallet->customer_id)->get();

            return view('miscellaneous.customer-wallet.view', compact('wallet', 'wallet_log'));
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Something Went Wrong');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerWallet  $customerWallet
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerWallet $customerWallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerWallet  $customerWallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerWallet $customerWallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerWallet  $customerWallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerWallet $customerWallet)
    {
        //
    }

    public function getWallet(Request $request){
        try{
            $customer = CustomerWallet::where('customer_id', $request->customer_id)->first();
            return response()->json(['status' => true, 'value' => $customer->amount, 'message' => 'Success']);
        } catch(\Throwable $th){
            return response()->json(['status' => false, 'message' => 'Customer Wallet not Exist']);
        }
    }
}
