<?php

namespace App\Http\Controllers;
use DB;
use Datatables;
use App\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getData(){
        return Datatables::of(PaymentMethod::query())->make(true);
     }
    public function index()
    {
        return view('payment-module.payment-method.payment');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment-module.payment-method.add');
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
            'name' => 'required|string|unique:payment_methods,name'
        ]);

        try {
            DB::beginTransaction();
            PaymentMethod::create([
                'name' => $request->name
            ]);
            DB::commit();
            return redirect('payment-methods')->with('message', 'Payment Method Added Successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Payment Method Not Added Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $method = PaymentMethod::where('id', decrypt($id))->first();
        return view('payment-module.payment-method.edit', compact('id', 'method'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:payment_methods,name,'.decrypt($id)
        ]);

        try {
            DB::beginTransaction();
            PaymentMethod::where('id', decrypt($id))->update([
                'name' => $request->name
            ]);
            DB::commit();
            return redirect('payment-methods')->with('message', 'Payment Method Updated Successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Payment Method Not Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        //
    }
}
