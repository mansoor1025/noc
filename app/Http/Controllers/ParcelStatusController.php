<?php

namespace App\Http\Controllers;

use App\ParcelStatus;
use Illuminate\Http\Request;

class ParcelStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parcels = ParcelStatus::all();
        return view('parcel-module.parcel-status.parcel-status', compact('parcels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('parcel-module.parcel-status.add');
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
            'name' => 'required|string|unique:parcel_statuses,parcel_status'
        ]);

        try {
            ParcelStatus::create([
                'parcel_status' => $request->name
            ]);

            return redirect('parcel-statuses')->with('message', 'Parcel Status Added Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Parcel Status Not Added Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ParcelStatus  $parcelStatus
     * @return \Illuminate\Http\Response
     */
    public function show(ParcelStatus $parcelStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ParcelStatus  $parcelStatus
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parcel = ParcelStatus::where('id', decrypt($id))->first();
        return view('parcel-module.parcel-status.edit', compact('id', 'parcel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ParcelStatus  $parcelStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:parcel_statuses,parcel_status,'.decrypt($id)
        ]);

        try {
            ParcelStatus::where('id', decrypt($id))->update([
                'parcel_status' => $request->name
            ]);

            return redirect('parcel-statuses')->with('message', 'Parcel Status Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Parcel Status not Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ParcelStatus  $parcelStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParcelStatus $parcelStatus)
    {
        //
    }
}
