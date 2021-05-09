<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use App\City;
use App\Customer;
use App\WeightRange;
use App\WeightRangeCityWise;
use Illuminate\Http\Request;

class WeightRangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role_id == 3){
            $u_id = Auth::user()->id;
            $c_id = Customer::where('user_id', $u_id)->first()->id;
            $weights = WeightRange::where('customer_id', $c_id)->with('customer')->with('range.city')->get();
            return view('miscellaneous.weight.weight', compact('weights'));
        } else {
            $weights = WeightRange::with('customer')->with('range.city')->get();
            return view('miscellaneous.weight.weight', compact('weights'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role_id == 3){
            $u_id = Auth::user()->id;
            $customers = Customer::where('user_id', $u_id)->get();
            $cities = City::all();
            return view('miscellaneous.weight.add', compact('cities', 'customers'));
        } else {
            $cities = City::all();
            $customers = Customer::all();
            return view('miscellaneous.weight.add', compact('cities', 'customers'));
        }
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
            'customer_id'       => 'required',
            'city_id.*'         => 'required',
            'rangeFrom.*'       => 'required|numeric',
            'rangeTo.*'         => 'required|numeric',
            'national_amount.*' => 'required|numeric',
            'local_amount.*'    => 'required|numeric'
        ]);
            
        //try {
            DB::beginTransaction();
            $range_id = [];
            //return $request;
            foreach($request->rangeFrom as $key => $value){
                $isExist = WeightRange::where([
                    'customer_id'     => $request->customer_id, 
                    'range_from'      => $request->rangeFrom[$key], 
                    'range_to'        => $request->rangeTo[$key],
                    'national_amount' => $request->national_amount[$key],
                    'local_amount'    => $request->local_amount[$key]
                ])->first();

                if($isExist == null){
                    $weight = WeightRange::create([
                        'customer_id'     => $request->customer_id,
                        'range_from'      => $request->rangeFrom[$key],
                        'range_to'        => $request->rangeTo[$key],
                        'national_amount' => $request->national_amount[$key],
                        'local_amount'    => $request->local_amount[$key]
                    ]);
                    array_push($range_id, $weight->id);
                } else {
                    array_push($range_id, $isExist->id);
                }
            }

            foreach($range_id as $key => $value1){        
                if($request->city_id[0] == 'All Cities'){
                    $cities = City::all();
                    foreach($cities as $key=>$value2){
                        $temp = [];
                        $temp = WeightRangeCityWise::where(['range_id' => $value1, 'city_id' => $value2->id]);
                        if($temp->first() == null){
                            foreach($range_id as $key=>$value3){
                                WeightRangeCityWise::create([
                                    'range_id' => $value3,
                                    'city_id'  => $value2->id
                                ]);
                            }
                        }
                    }
                } else {
                    foreach($request->city_id as $key=>$value4){
                        $temp = [];
                        $temp = WeightRangeCityWise::where(['range_id' => $value1, 'city_id' => $value4])->first();
                        if($temp == null){
                            foreach($range_id as $key=>$value5){
                                WeightRangeCityWise::create([
                                    'range_id' => $value5,
                                    'city_id'  => $value4
                                ]);
                            }
                        }
                    }
                }                
            }

            DB::commit();
            return redirect('weights')->with('message', 'Weight Added Successfully');
        /*} catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Weight not Added Successfully');
        }*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WeightRange  $weightRange
     * @return \Illuminate\Http\Response
     */
    public function show(WeightRange $weightRange)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WeightRange  $weightRange
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $weight = WeightRange::where('id', decrypt($id))->with('range.city')->first();
        foreach($weight->range as $value){
            $cities[] = $value->city->id;
        }
        $customers = Customer::all();
        $cities = City::whereNotIn('id', $cities)->get();
        return view('miscellaneous.weight.edit', compact('id', 'weight', 'customers', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WeightRange  $weightRange
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'rangeFrom'       => 'required|numeric',
            'rangeTo'         => 'required|numeric',
            'national_amount' => 'required|numeric',
            'local_amount'    => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();
            $range_id;
            $isExist = WeightRange::where([
                'range_from'      => $request->rangeFrom, 
                'range_to'        => $request->rangeTo, 
                'national_amount' => $request->national_amount, 
                'local_amount'    => $request->local_amount
            ])->first();

            if($isExist == null){
                $weight = WeightRange::where('id', decrypt($id))->update([
                    'range_from'      => $request->rangeFrom,
                    'range_to'        => $request->rangeTo,
                    'national_amount' => $request->national_amount,
                    'local_amount'    => $request->local_amount
                ]);
                $range_id = $id;
            } else {
                $range_id = $isExist->id;
            }

            if($request->old_city_id){
                if(count($request->old_city_id)){
                    $weight = WeightRange::where('id', decrypt($id))->with('range.city')->first();
                    $city_ids = [];
                    
                    foreach($weight->range as $value){
                        $city_ids[] = $value->city->id;
                    }
                    $diff = array_diff($city_ids, $request->old_city_id);
                   
                    if(count($diff)){
                        WeightRangeCityWise::whereIn('city_id', $diff)->where('range_id', decrypt($id))->delete();
                    }
                }
            }

            if($request->new_city_id){
                if($request->new_city_id[0] == 'All Cities'){
                    $cities = City::all();
                    foreach($cities as $key=>$value){
                        $temp = [];
                        $temp = WeightRangeCityWise::where(['range_id' => $range_id , 'city_id' => $value->id])->first();
                        if($temp == null){
                            WeightRangeCityWise::create([
                                'range_id' => $range_id,
                                'city_id'  => $value->id,
                            ]);
                        }
                    }
                } else {
                    foreach($request->new_city_id as $key=>$value){
                        $temp = [];
                        $temp = WeightRangeCityWise::where(['range_id' => $range_id, 'city_id' => $value])->first();
                        if($temp == null){
                            WeightRangeCityWise::create([
                                'range_id' => $range_id,
                                'city_id'  => $value,
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect('weights')->with('message', 'Weight Updated Successfully');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Weight not Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WeightRange  $weightRange
     * @return \Illuminate\Http\Response
     */
    public function destroy(WeightRange $weightRange)
    {
        //
    }

    public function getCities(Request $request){
        $data = WeightRange::where([
            'customer_id'     => $request->data['customer_id'],
            'range_from'      => $request->data['range_from'],
            'range_to'        => $request->data['range_to'],
            'national_amount' => $request->data['national_amount'],
            'local_amount'    => $request->data['local_amount'],
        ])->with('city')->get();

        return response()->json(['status' => true, 'data' => $data]);
    }
}
