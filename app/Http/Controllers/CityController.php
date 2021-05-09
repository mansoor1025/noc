<?php

namespace App\Http\Controllers;
use DB;
use App\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        return view('miscellaneous.city.city', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('miscellaneous.city.add');
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
            'code' => 'required|string',
            'city' => 'required|string|unique:cities,name',
        ]);

        try {
            DB::beginTransaction();
            City::create([
                'code'   => $request->code,
                'name'   => $request->city,
                'status' => 1
            ]);

            DB::commit();
            return redirect('cities')->with('message', 'City Added Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'City Not Added Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::where('id', decrypt($id))->first();
        return view('miscellaneous.city.edit', compact('id', 'city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string',
            'city' => 'required|string|unique:cities,name,'.decrypt($id),
        ]);

        try {
            DB::beginTransaction();
            City::where('id', decrypt($id))->update([
                'code'   => $request->code,
                'name'   => $request->city,
                'status' => 1
            ]);

            DB::commit();
            return redirect('cities')->with('message', 'City Added Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'City Not Added Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        //
    }
}
