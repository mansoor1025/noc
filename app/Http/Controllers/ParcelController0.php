<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\City;
use App\Parcel;
use App\Province;
use App\Customer;
use App\ParcelLog;
use App\WeightRange;
use App\ParcelStatus;
use App\ShippingPartner;
use App\WeightRangeCityWise;
use Illuminate\Http\Request;
use App\Exports\ParcelExport;
use App\Exports\ParcelsExport;
use App\Imports\ImportParcels;
use Maatwebsite\Excel\Facades\Excel;

use PDF;

class ParcelController extends Controller
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
            $statuses  = ParcelStatus::all();
            $parcels = Parcel::where('customer_id', $c_id)->with('customer')->with('status')->with('partner')->orderBy('id', 'DESC')->get();
            //return $parcels;
            $cities = City::all();
            return view('parcel-module.parcel.parcel', compact('parcels', 'statuses', 'cities'));
        } else {
            $statuses  = ParcelStatus::all();
            $parcels = Parcel::with('customer')->with('status')->with('partner')->orderBy('id', 'DESC')->get();
            //return $parcels;
            $cities = City::all();
            return view('parcel-module.parcel.parcel', compact('parcels', 'statuses', 'cities'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role_id ==  3){
            $u_id = Auth::user()->id;
            $cities = City::all();
            $provinces = Province::all();
            $customers = Customer::where('user_id', $u_id)->get();
            $statuses  = ParcelStatus::all();
            $partners  = ShippingPartner::all();
            return view('parcel-module.parcel.add', compact('customers', 'statuses', 'partners', 'cities', 'provinces'));
        } else {
            $cities = City::all();
            $provinces = Province::all();
            $customers = Customer::all();
            $statuses  = ParcelStatus::all();
            $partners  = ShippingPartner::all();
            return view('parcel-module.parcel.add', compact('customers', 'statuses', 'partners', 'cities', 'provinces'));
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
            'customer_id'     => 'required',
            'status_id'       => 'required',
            'shipping_id'     => 'required',
            'province_id'     => 'required',
            'weight'          => 'required',
            'reference_no'    => 'required',
            'username'        => 'required|string',
            'email'           => 'required|email',
            'mobile_no'       => 'required|numeric',
            'address'         => 'required|string',
            'city_id'         => 'required',
            'cod'             => 'required|numeric'
        ]);

        //try {
            DB::beginTransaction();

            $manual = false;
            
            $origin_city = Customer::where('id', $request->customer_id)->first()->city;
            $destinaition_city = City::where('id', $request->city_id)->first()->name;
            
            if($request->shipping_id == 2){
                $username = 't.pakistan';
                $password = 't.pakistan1';
                $center_code = '040688';
                $service = 'O';

                $arr = [
                    "userName"              => $username,
                    "password"              => $password,
                    "costCenterCode"        => $center_code,
                    "consigneeName"         => $request->username,
                    "consigneeAddress"      => $request->address,
                    "consigneeMobNo"        => $request->mobile_no,
                    "consigneeEmail"        => $request->email,
                    "originCityName"        => $origin_city,
                    "destinationCityName"   => $destinaition_city,
                    "weight"                => $request->weight,
                    "pieces"                => 1,
                    "codAmount"             => $request->cod,
                    "customerReferenceNo"   => "123",
                    "services"              => $service,
                    "productDetails"        => "wobd",
                    "fragile"               => "Yes",
                    "remarks"               => "remarks",
                    "insuranceValue"        => 1
                ];

                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://apis.tcscourier.com/production/v1/cod/create-order",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($arr, JSON_FORCE_OBJECT),
                    CURLOPT_HTTPHEADER => array(
                        "accept: application/json",
                        "content-type: application/json",
                        "x-ibm-client-id: 8e121677-f237-4ee0-955c-92d8e7bec15a"
                    ),
                ));
        
                $response = curl_exec($curl);
                $err = curl_error($curl);
        
                curl_close($curl);

                if ($err) {
                    return redirect()->back()->withInput()->with('error', 'Parcel not Added Successfully');
                } else {
                    $source_id = 3;
                    $res = json_decode($response, true);
                    //return $res;
                    $tracking_no = substr($res['bookingReply']['result'], 22);
                }

            } else {
                $manual = true;
                $source_id = 1;

                //Get Last Parcel Number
                $customer = Customer::where('id', $request->customer_id)->first();
                $tracking_no = $customer->last_parcel_no + 1;
                
            }

            // Check Weight is greater or less than 3
            if($request->weight > 3){
                $range = WeightRange::where([
                    ['customer_id' ,'=', $request->customer_id],
                    ['range_from', '=', 3.1],
                    ['range_to', '=', 3.1],
                ])->get();

                $ranges = WeightRange::where([
                    ['customer_id' ,'=', $request->customer_id],
                    ['range_from', '=', 1.1],
                    ['range_to', '=', 3],
                ])->select('national_amount', 'local_amount')->get();
                
            } else {
                $range = WeightRange::where([
                    ['customer_id' ,'=', $request->customer_id],
                    ['range_from', '<=', $request->weight],
                    ['range_to', '>=', $request->weight]
                ])->get();
            }

            //return $range; 

            // Calculate Shipping Charges
            foreach($range as $key=>$value){
                $temp = WeightRangeCityWise::where([
                    'range_id' => $range[$key]->id,
                    'city_id'  => $request->city_id
                ])->first();

                //return $temp;
                
                if($temp){
                    $index = $key;
                    $city = City::where('id', $temp->city_id)->first();
                    
                    if($origin_city == $city->name){
                        $shipping_amount = $range[$key]->local_amount;
                        $per_kg_charges   = $ranges[$key]->local_amount ?? 0;
                    } else {
                        $shipping_amount = $range[$key]->national_amount;
                        $per_kg_charges  = $ranges[$key]->national_amount ?? 0;
                    }

                    if($request->weight > 3){
                        $diff = $request->weight - 3;
                        $total = ($per_kg_charges * $diff) + $shipping_amount;
                        $shipping_amount = $total;
                    }
                }
            }
            
            $parcel = Parcel::create([
                'parcel_status_id'    => $request->status_id,
                'customer_id'         => $request->customer_id,
                'shipping_partner_id' => $request->shipping_id,
                'source_id'           => $source_id,
                'province_id'         => $request->province_id,
                'weight'              => $request->weight,
                'tracking_id'         => $tracking_no,
                'reference_no'        => $request->reference_no,
                'user_name'           => $request->username,
                'email'               => $request->email,
                'mobile_no'           => $request->mobile_no,
                'user_address'        => $request->address,
                'destination_city'    => $destinaition_city,
                'cod_amount'          => $request->cod,
                'shipping_amount'     => $shipping_amount,
                'total_amount'        => $request->cod + $shipping_amount,
                'rider_print'         => false,
                'validate'            => false,
                'bit'                 => 0
            ]);

            if($manual == true){
                Customer::where('id', $request->customer_id)->update([
                    'last_parcel_no' => $parcel->tracking_id
                ]);
            }

            ParcelLog::create([
                'user_id'          => Auth::user()->id,
                'parcel_id'        => $parcel->id,
                'parcel_status_id' => $request->status_id,
                'description'      => 'Parcel Created'
            ]);

            DB::commit();

            return redirect('parcels')->with('message', 'Parcel Added Successfully');
        /*} catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Parcel not Added Successfully');
        }*/
    }
        
    /**
     * Display the specified resource.
     *
     * @param  \App\Parcel  $parcel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if(Auth::user()->role_id ==  3){
            $u_id = Auth::user()->id;
            $cities = City::all();
            $provinces = Province::all();
            $customers = Customer::where('user_id', $u_id)->get();
            $statuses  = ParcelStatus::all();
            $partners  = ShippingPartner::all();
            $parcel    = Parcel::where('id', decrypt($id))->first();
            return view('parcel-module.parcel.view', compact('cities', 'provinces', 'customers', 'statuses', 'partners', 'parcel'));
        } else {
            $cities = City::all();
            $customers = Customer::all();
            $provinces = Province::all();
            $statuses  = ParcelStatus::all();
            $partners  = ShippingPartner::all();
            $parcel    = Parcel::where('id', decrypt($id))->first();
            return view('parcel-module.parcel.view', compact('cities', 'provinces', 'customers', 'statuses', 'partners', 'parcel'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parcel  $parcel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role_id ==  3){
            $u_id = Auth::user()->id;
            $cities = City::all();
            $provinces = Province::all();
            $customers = Customer::where('user_id', $u_id)->get();
            $statuses  = ParcelStatus::all();
            $partners  = ShippingPartner::all();
            $parcel    = Parcel::where('id', decrypt($id))->first();
            return view('parcel-module.parcel.edit', compact('id', 'cities', 'provinces', 'customers', 'statuses', 'partners', 'parcel'));
        } else {
            $cities = City::all();
            $provinces = Province::all();
            $customers = Customer::all();
            $statuses  = ParcelStatus::all();
            $partners  = ShippingPartner::all();
            $parcel    = Parcel::where('id', decrypt($id))->first();
            return view('parcel-module.parcel.edit', compact('id', 'cities', 'provinces', 'customers', 'statuses', 'partners', 'parcel'));
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id'     => 'required',
            'shipping_id'     => 'required',
            'province_id'     => 'required',
            'weight'          => 'required',
            'reference_no'    => 'required',
            'username'        => 'required|string',
            'email'           => 'required|email',
            'mobile_no'       => 'required|numeric',
            'address'         => 'required|string',
            'city_id'         => 'required',
            'cod'             => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            $parcel = Parcel::where('id', decrypt($id))->first();
            $tracking_id = $parcel->tracking_id;
            $source_id = $parcel->source_id;

            $destinaition_city = City::where('id', $request->city_id)->first()->name;
            $origin_city = Customer::where('id', $request->customer_id)->first()->city;
    
            if($request->shipping_id == 2){
                $username = 't.pakistan';
                $password = 't.pakistan1';
                $center_code = '040688';
                $service = 'O';

                $arr = [
                    "userName"              => $username,
                    "password"              => $password,
                    "costCenterCode"        => $center_code,
                    "consigneeName"         => $request->username,
                    "consigneeAddress"      => $request->address,
                    "consigneeMobNo"        => $request->mobile_no,
                    "consigneeEmail"        => $request->email,
                    "originCityName"        => $origin_city,
                    "destinationCityName"   => $destinaition_city,
                    "weight"                => $request->weight,
                    "pieces"                => 1,
                    "codAmount"             => $request->cod,
                    "customerReferenceNo"   => "123",
                    "services"              => $service,
                    "productDetails"        => "wobd",
                    "fragile"               => "Yes",
                    "remarks"               => "remarks",
                    "insuranceValue"        => 1
                ];

                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://apis.tcscourier.com/production/v1/cod/create-order",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($arr, JSON_FORCE_OBJECT),
                    CURLOPT_HTTPHEADER => array(
                        "accept: application/json",
                        "content-type: application/json",
                        "x-ibm-client-id: 8e121677-f237-4ee0-955c-92d8e7bec15a"
                    ),
                ));
        
                $response = curl_exec($curl);
                $err = curl_error($curl);
        
                curl_close($curl);

                if ($err) {
                    return redirect()->back()->withInput()->with('error', 'Parcel not Added Successfully');
                } else {
                    $source_id = 3;
                    $res = json_decode($response, true);
                    $tracking_id = substr($res['bookingReply']['result'], 22);
                }
            } else {
                $source_id = 1;
                $customer = Customer::where('id', $request->customer_id)->first();
            }

            // if Weight Change
            if($request->weight == $parcel->weight){
                $shipping_amount = $parcel->shipping_amount;
            } else {
                // Check Weight is greater or less than 3
                if($request->weight > 3){
                    $range = WeightRange::where([
                        ['customer_id' ,'=', $request->customer_id],
                        ['range_from', '=', 3.1],
                        ['range_to', '=', 3.1],
                    ])->get();
    
                    $ranges = WeightRange::where([
                        ['customer_id' ,'=', $request->customer_id],
                        ['range_from', '=', 1.1],
                        ['range_to', '=', 3],
                    ])->select('national_amount', 'local_amount')->get();
                    
                } else {
                    $range = WeightRange::where([
                        ['customer_id' ,'=', $request->customer_id],
                        ['range_from', '<=', $request->weight],
                        ['range_to', '>=', $request->weight]
                    ])->get();
                }
    
                // Calculate Shipping Charges
                foreach($range as $key=>$value){
                    $temp = WeightRangeCityWise::where([
                        'range_id' => $range[$key]->id,
                        'city_id'  => $request->city_id
                    ])->first();
                    
                    if($temp){
                        $index = $key;
                        $city = City::where('id', $temp->city_id)->first();
                        
                        if($origin_city == $city->name){
                            $shipping_amount = $range[$key]->local_amount;
                            $per_kg_charges   = $ranges[$key]->local_amount ?? 0;
                        } else {
                            $shipping_amount = $range[$key]->national_amount;
                            $per_kg_charges  = $ranges[$key]->national_amount ?? 0;
                        }
    
                        if($request->weight > 3){
                            $diff = $request->weight - 3;
                            $total = ($per_kg_charges * $diff) + $shipping_amount;
                            $shipping_amount = $total;
                        }
                    }
                }
            }
            
            Parcel::where('id', decrypt($id))->update([
                'customer_id'         => $request->customer_id,
                'shipping_partner_id' => $request->shipping_id,
                'source_id'           => $source_id,
                'province_id'         => $request->province_id,
                'weight'              => $request->weight,
                'tracking_id'         => $tracking_id,
                'reference_no'        => $request->reference_no,
                'user_name'           => $request->username,
                'email'               => $request->email,
                'mobile_no'           => $request->mobile_no,
                'user_address'        => $request->address,
                'destination_city'    => $destinaition_city,
                'cod_amount'          => $request->cod,
                'shipping_amount'     => $shipping_amount,
                'total_amount'        => $request->cod + $shipping_amount,
                'rider_print'         => $request->rider,
                'validate'            => $request->validate
            ]);

            DB::commit();

            return redirect('parcels')->with('message', 'Parcel Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Parcel not Updated Successfully');
        }      
    }
    
    public function destroy(Parcel $parcel)
    {
        //
    }

    public function changeStatus(Request $request){
        try{
            $parcel = Parcel::find($request->parcel_id);
            $parcel->parcel_status_id = $request->status_id;
            $parcel->save();

            ParcelLog::create([
                'user_id'          => Auth::user()->id,
                'parcel_id'        => $request->parcel_id,
                'parcel_status_id' => $request->status_id,
                'description'      => 'Parcel Status Changed'
            ]);
            
            return response()->json(['status' => true, 'message' => 'Status change successfully.']);
        } catch(\Throwable $th){
            return response()->json(['status' => false, 'message' => 'Something Went Wrong']);
        }
    }

    public function import() {
        try {
            Excel::import(new ImportParcels, request()->file('file'));
            return back()->with('success', 'Excel Data Imported successfully.');
        } catch (\Throwable $th) {
            dd($th);
            return back()->with('error', 'Excel Data Not Imported successfully.');
        }
    }

    public function export() {
        return Excel::download(new ParcelsExport, 'example.xlsx');
    }

    public function validateParcel(Request $request){
        try {
            $isExist = Parcel::where('tracking_id', $request->tracking_id)->update([
                'validate'         => 1,
                'parcel_status_id' => 6
            ]);
            $parcel = Parcel::where('tracking_id', $request->tracking_id)->with('customer')->with('partner')->first();

            $customer = Customer::where('id', $parcel->customer_id)->first();
            $user_id = $customer->user_id;

            //--
            ParcelLog::create([
                'user_id'          => $user_id,
                'parcel_id'        => $parcel->id,
                'parcel_status_id' => 6,    //Arrived At Office
                'description'      => 'Parcel Status Changed (Arrived At Office)'
            ]);
            //--

            return view('parcel-module.validate-parcel.validate' ,compact('parcel'));
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Something Went Wrong');
        }
    }

    public function returnParcel(){
        $return_parcels = Parcel::where('parcel_status_id', 5)->get();
        return view('parcel-module.return-parcel.parcel-return', compact('return_parcels'));
    }

    public function parcelReturn(Request $request){
        try {
            $isExist = Parcel::where('tracking_id', $request->tracking_no)->update(['parcel_status_id' => 5]);
            return redirect()->back()->with('message', 'Parcel Return Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Something Went Wrong');
        }
    }

    public function exportParcelDateWise(Request $request){
        $from_date=$request->from_date;
        $to_date = $request->to_date;

        return Excel::download(new ParcelExport($from_date, $to_date), 'parcels.xlsx');

        /*return DB::table('parcels as p')
            ->join('parcel_statuses as ps', 'ps.id', '=', 'p.parcel_status_id')
            ->join('customers as c', 'c.id', '=', 'p.customer_id')
            
            //->join('parcel_logs as pl', 'pl.parcel_id', '=', 'p.id')
            ->leftJoin('parcel_logs as pl', function ($join) {
                $join->on('p.id', '=', 'pl.parcel_id')
                     ->where('pl.parcel_status_id', '=', 6);
            })

            ->select('c.full_name', 'ps.parcel_status', 'p.weight', 'p.tracking_id', 'p.reference_no', 'p.user_name',
                'p.email', 'p.mobile_no', 'p.user_address', 'p.cod_amount', 'p.shipping_amount', 'p.total_amount', 'pl.description', 'pl.created_at')
            ->orderBy('p.created_at', 'desc')->get();*/

    }

    public function print($id){
        $parcel = Parcel::where('id', decrypt($id))->with('customer')->with('status')->with('partner')->first();
        return view('parcel-module.parcel.print', compact('parcel'));
    }

    public function print_multiple_invoice($array){
        $array = json_decode($array);
        //print_r($array);

        //$parcels = Parcel::where('id', $array[0])->with('customer')->with('status')->with('partner')->get();
        $parcels = Parcel::whereIn('id', $array)->with('customer')->with('status')->with('partner')->get();
        return view('parcel-module.parcel.print_multiple', compact('parcels'));

        /*$data = [
            'title'   => 'Parcel',
            'parcel' => $parcel
        ];
        
        $pdf = PDF::loadView('parcel-module.parcel.print_multiple', $data);
        return $pdf->stream('parcel.pdf');*/

    }

    public function barcode(){
        return view('barcode');
    }

    public function cityChangeParcelBook(){
        return 'cityChangeParcelBook here';
    }

}
