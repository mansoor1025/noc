<?php

namespace App\Http\Controllers;

use App\ShippingPartner;
use Illuminate\Http\Request;

class ShippingPartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = ShippingPartner::all();
        return view('shipping-module.shipping-partner.shipping', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shipping-module.shipping-partner.add');
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
            'name' => 'required|string'
        ]);

        try {
            ShippingPartner::create([
                'name'   => $request->name,
                'status' => 1
            ]);

            return redirect('shipping-partners')->with('message', 'Shipping Partner Added Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Shipping Partner Not Added Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShippingPartner  $shippingPartner
     * @return \Illuminate\Http\Response
     */
    public function show(ShippingPartner $shippingPartner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShippingPartner  $shippingPartner
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $partner = ShippingPartner::where('id', decrypt($id))->first();
        return view('shipping-module.shipping-partner.edit', compact('id', 'partner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShippingPartner  $shippingPartner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        try {
            ShippingPartner::where('id', decrypt($id))->update([
                'name' => $request->name
            ]);
            
            return redirect('shipping-partners')->with('message', 'Shipping Partner Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Shipping Partner Not Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShippingPartner  $shippingPartner
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShippingPartner $shippingPartner)
    {
        //
    }
}
