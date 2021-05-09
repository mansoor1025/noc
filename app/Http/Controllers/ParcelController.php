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
use App\Exports\validateparcel; 
use PDF;
use Illuminate\Support\Facades\Validator;


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
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://apis.tcscourier.com/production/v1/cod/cities",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"accept: application/json",
			"content-type: application/json",
			"x-ibm-client-id: 8e121677-f237-4ee0-955c-92d8e7bec15a"
		),
		));
        
		$response = curl_exec($curl);
		$err = curl_error($curl);
		$a = [];
		curl_close($curl);

		if ($err) {
			return redirect()->back()->withInput()->with('error', 'Parcel not Added Successfully');
		} else {
			$source_id = 3;
			$cities_name = json_decode($response, true);
			if(Auth::user()->role_id ==  3){
            $u_id = Auth::user()->id;
            $cities = City::all();
            $provinces = Province::all();
            $customers = Customer::where('user_id', $u_id)->get();
            $statuses  = ParcelStatus::all();
            $partners  = ShippingPartner::all();
            return view('parcel-module.parcel.add', compact('customers', 'statuses', 'partners', 'cities', 'provinces','cities_name'));
			} else {
            $cities = City::all();
            $provinces = Province::all();
            $customers = Customer::all();
            $statuses  = ParcelStatus::all();
            $partners  = ShippingPartner::all();
            return view('parcel-module.parcel.add', compact('customers', 'statuses', 'partners', 'cities', 'provinces','cities_name'));
          }
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
	
		$shipping_amount = 0;
        $request->validate([
            'customer_id'     => 'required',
            'status_id'       => 'required',
            'province_id'     => 'required',
            'weight'          => 'required|numeric', 
            'reference_no'    => 'required', 
            'username'        => 'required|string|min:3|max:50',  
            'mobile_no'       => 'required|size:11',  
            'address'         => ['required',
										function ($attribute, $value, $fail) { 
											if (is_int($value) && $value > 100) {
												$fail($attribute . ' must be less than 30.');
											} else if (is_string($value) && strlen($value) > 100 ) {
												$fail($attribute . ' must be less than 100 characters.');
											}
										},
									],
            'city_id'         => 'required',
            'cod'             => 'required|numeric',
			'product_Detail'  => 'required'
        ]);  
        $final_weight = 0;
		$round_weight = round($request->weight);
        $service_type = ''; 
		
		if($round_weight == 2 || $round_weight <! 2){   
			$final_weight = 3;
		}
		else{
			$final_weight = $round_weight; 
		}
      
        //try {
           // DB::beginTransaction();

            $manual = false;
            $origin_city = Customer::where('id', $request->customer_id)->first()->city;
			//$origin_city = DB::table('api_cities')->where('city_code', $request->customer_id)->first()->city_name;
            $destinaition_city = DB::table('api_cities')->where('city_code', $request->city_id)->first()->city_name;
			if($request->shipping_id == 1){
				$manual = true; 
                $source_id = 1;
                //Get Last Parcel Number
                $customer = Customer::where('id', $request->customer_id)->first();
                $tracking_no = $customer->last_parcel_no + 1; 
			}
            else if($request->shipping_id == 2){
                $username = 'DEALPAKISTAN';
                $password = 'abc123@';
                $center_code = 'DDP001';
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
                    "weight"                => $final_weight,
                    "pieces"                => 1,
                    "codAmount"             => $request->cod,
                    "customerReferenceNo"   => $request->reference_no,
                    "services"              => $service,
                    "productDetails"        => $request->product_Detail, 
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
					if($res['returnStatus']['status'] == 'SUCCESS'){
						$tracking_no = substr($res['bookingReply']['result'], 22);
					}
					
					else{
                      return redirect()->back()->withInput()->with('error', $res['returnStatus']['message']);
					 }
				}
                
                $service_type = 'deal_pakistan';
             } else {
                $manual = true;
                $source_id = 1;
                //Get Last Parcel Number
                $customer = Customer::where('id', $request->customer_id)->first();
                $tracking_no = $customer->last_parcel_no + 1;
             }
            
            // Check Weight is greater or less than 3
            if($final_weight > 3){
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
                    ['range_from', '<=', $final_weight],
                    ['range_to', '>=', $final_weight]
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
            $special_handling = 'MUST CALL BEFORE DELIVERY '.$tracking_no;
            $parcel = Parcel::create([
                'parcel_status_id'    => $request->status_id,
                'customer_id'         => $request->customer_id,
                'shipping_partner_id' => $request->shipping_id,
                'source_id'           => $source_id,
                'province_id'         => $request->province_id,
                'weight'              => $final_weight,
                'tracking_id'         => $tracking_no,
                'reference_no'        => $request->reference_no,
                'user_name'           => $request->username,
                'email'               => $request->email,
                'mobile_no'           => $request->mobile_no,
                'user_address'        => $request->address,
                'destination_city'    => $destinaition_city,
                'cod_amount'          => $request->cod,
                'shipping_amount'     => $shipping_amount,
				'product_detail'      => $request->product_Detail,
				'pieces'      		  => 1, 
				'special_handling'    => $special_handling,
				'service_type'        => $service_type, 
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
	  
		   //$check_array = explode("-",$id);
		//print_r($check_array);
		   
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
            $parcel = Parcel::where('tracking_id', $request->tracking_id)->where('export_status',0)->with('customer')->with('partner')->first();

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

    public function cityChangeParcelBook(Request $request){
        //return $request->city_id.$request->parcel_id;
        $parcel    = Parcel::where('id', $request->parcel_id)->first();
        
        //--//
        
                //--
                $u_id = Auth::user()->id;
                $customer = Customer::where('user_id', $u_id)->first();
                //dd($customer->id);
                //dd($customer);
                $customer_id = $customer->id;
        
                //Get Last Parcel Number
                //$customer = Customer::where('id', $customer_id)->first();
                $tracking_no = $customer->last_parcel_no + 1;
                //return $tracking_no;
                //--
        
                //$origin_city = Customer::where('id', $parcel['customer_id'])->first()->city;
                $origin_city = Customer::where('id', $customer_id)->first()->city;
                //dd($origin_city);
        
                //old get destination_city from destination_city_id
                $destination_city = City::where('id', $request->city_id)->first()->name;
                //new directly get destination_city
                //$destination_city = $parcel['destination_city'];
                //new get destination_city_id from destination_city name, old destination_city_id was directly given
                //$destination_city_id = City::where('name', $parcel['destination_city'])->first()->id;
                $destination_city_id = $request->city_id;
        
                $province_id = Province::where('id', $parcel['province_id'])->first()->id;
        
                    //--
                    // Check Weight is greater or less than 3
                    if($parcel['weight'] > 3){
                        $range = WeightRange::where([
                            ['customer_id' ,'=', $customer_id],
                            ['range_from', '=', 3.1],
                            ['range_to', '=', 3.1],
                        ])->get();
        
                        $ranges = WeightRange::where([
                            ['customer_id' ,'=', $customer_id],
                            ['range_from', '=', 1.1],
                            ['range_to', '=', 3],
                        ])->select('national_amount', 'local_amount')->get();
                        
                    } else {
                        $range = WeightRange::where([
                            ['customer_id' ,'=', $customer_id],
                            ['range_from', '<=', $parcel['weight']],
                            ['range_to', '>=', $parcel['weight']]
                        ])->get();
                    }
        
                    //return $range; 
        
                    // Calculate Shipping Charges
                    foreach($range as $key=>$value){
                        $temp = WeightRangeCityWise::where([
                            'range_id' => $range[$key]->id,
                            'city_id'  => $destination_city_id
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
        
                            if($parcel['weight'] > 3){
                                $diff = $parcel['weight'] - 3;
                                $total = ($per_kg_charges * $diff) + $shipping_amount;
                                $shipping_amount = $total;
                            }
                        }
                    }
                    //--
        
                if($destination_city != 'Karachi' && $destination_city != 'Hyderabad' && $destination_city != 'Lahore'){
                    if($parcel['weight'] > 0 && $parcel['weight'] <= 1){
                        $username = 'DEALPAKISTAN';
                        $password = 'abc123@';
                        $center_code = 'DDP001';
                        $service = 'O';
                    } 
                    else if($parcel['weight'] > 1 && $parcel['weight'] <= 3){
                        if($province_id == '1' || $province_id == '3'){
                            $username = 'trust.paksitan';
                            $password = '1234hanif';
                            $center_code = '039596';
                            $service = 'O';
                        } else {
                            $username = 'trust.paksitan';
                            $password = '1234hanif';
                            $center_code = '039596';
                            $service = 'D';
                        }
                    }
                    else if($parcel['weight'] > 3){
                        if($province_id == '1' || $province_id == '3'){
                            $username = 'trust.paksitan';
                            $password = '1234hanif';
                            $center_code = '039596';
                            $service = 'O';
                        } else {
                            $username = 'hizab';
                            $password = 'HIZAB123+';
                            $center_code = '042443';
                            $service = 'D';
                        }
                    }
                //}
        
                $arr = [
                    "userName"            => $username,
                    "password"            => $password,
                    "costCenterCode"      => $center_code,
                    "consigneeName"       => $parcel['user_name'],
                    "consigneeAddress"    => $parcel['user_address'],
                    "consigneeMobNo"      => $parcel['mobile_no'],
                    "consigneeEmail"      => $parcel['email'],
                    "originCityName"      => $origin_city,
                    "destinationCityName" => $destination_city,
                    "weight"              => $parcel['weight'],
                    "pieces"              => 1,
                    "codAmount"           => $parcel['cod_amount'],
                    "customerReferenceNo" => "123",
                    "services"            => $service,
                    "productDetails"      => "wobd",
                    "fragile"             => "No",
                    "remarks"             => "remarks",
                    "insuranceValue"      => 1
                ];
                //dd($arr);
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
                    return back()->with('error', 'Excel Data Not Imported successfully.');
                } else {
                    //dd($response);
                    $res = json_decode($response, true);
        
                    Parcel::where('id', $request->parcel_id)->update([
                        'parcel_status_id'    => 7,
                        'customer_id'         => $customer_id,
                        'shipping_partner_id' => 2,
                        'source_id'           => 2,
                        'weight'              => $parcel['weight'],
                        'tracking_id'         => substr($res['bookingReply']['result'], 22),
                        'reference_no'        => $parcel['reference_no'],
                        'user_name'           => $parcel['user_name'],
                        'email'               => $parcel['email'],
                        'mobile_no'           => $parcel['mobile_no'],
                        'user_address'        => $parcel['user_address'],
                        'cod_amount'          => $parcel['cod_amount'],
                        'shipping_amount'     => $shipping_amount,
                        'total_amount'        => $parcel['cod_amount'] + $shipping_amount,
                        'rider_print'         => $parcel['rider_print'],
                        'validate'            => 0,
                        'destination_city'    => $destination_city
                    ]);
                }
        
                }//endif
                else{
        
                    $parcel = Parcel::where('id', $request->parcel_id)->update([
                        'parcel_status_id'    => 7, //Booking
                        'customer_id'         => $customer_id,
                        'shipping_partner_id' => 1,
                        'source_id'           => 2,
                        'weight'              => $parcel['weight'],
                        'tracking_id'         => $tracking_no,
                        'reference_no'        => $parcel['reference_no'],
                        'user_name'           => $parcel['user_name'],
                        'email'               => $parcel['email'],
                        'mobile_no'           => $parcel['mobile_no'],
                        'user_address'        => $parcel['user_address'],
                        'cod_amount'          => $parcel['cod_amount'],
                        'shipping_amount'     => $shipping_amount,
                        'total_amount'        => $parcel['cod_amount'] + $shipping_amount,
                        'rider_print'         => false,
                        'validate'            => false,
                        //'bit'                 => 0,
                        'destination_city'    => $destination_city
                    ]);
        
                    Customer::where('id', $customer_id)->update([
                        'last_parcel_no' => $tracking_no
                    ]);
        
                    ParcelLog::create([
                        'user_id'          => Auth::user()->id,
                        'parcel_id'        => $request->parcel_id,
                        'parcel_status_id' => 7,    //Booking
                        'description'      => 'Parcel rebook city change'
                    ]);
        
                }
        
        //--//

    }

    public function parcelStatus(Request $request){
        //return $request;
        $tracking_id = $request->tracking_id;
        return Parcel::where('tracking_id', $tracking_id)->with('status')->with('partner')/*->with('statuslog.status')*/->first();
    }
	
	public function add_parcel(Request $request){
		
		$shipping_amount = 0;
		$main_shipping_id = 0;
        $validator = Validator::make($request->all(), [
			'company_name'    => 'required',
            'customer_name'   => 'required',
            'status_id'       => 'required',
            'province_name'     => 'required',
            'weight'          => 'required',
            'reference_no'    => 'required',
            'username'        => 'required|string',
            'email'           => 'required|email',
            'mobile_no'       => 'required|numeric',
            'address'         => 'required|string',
            'city_name'         => 'required',
            'cod'             => 'required|numeric',
			'total_amount'    => 'required|numeric',
			'shipping_amount' => 'required|numeric'
        ]);
		 if($validator->passes()){
		
			$customer_id = Customer::where('full_name', $request->customer_name);
			$des_city = DB::table('api_cities')->where('city_name', $request->city_name);
			$shipping_name = DB::table('shipping_partners')->where('name', $request->shipping_name);
			$province_name = DB::table('provinces')->where('name', $request->province_name);
			$company_name = Customer::where('company_name', $request->company_name);
			if(!$customer_id->exists()){
				return 'customer not exists';
			}
			if(!$des_city->exists()){
				return 'city name not exists';
			}
			if(!$province_name->exists()){
				return 'province name not exists';
			}
			if(!$company_name->exists()){
				return 'company name not exists';
			}
		   
            $manual = false;
            $origin_city = $customer_id ->first()->city;
			
            $destinaition_city = $des_city->first()->city_name;
			
			if($des_city->first()->city_code == 'KHI' || $des_city->first()->city_code == 'HDD' || $des_city->first()->city_code == 'LHE'){
				$main_shipping_id = 1;
			}
			else{
				$main_shipping_id = 2;
			}
		  
            if($main_shipping_id == 2){
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
                    return 'Parcel not Added Successfully';
                } else {
                    $source_id = 3;
                    $res = json_decode($response, true);
                    //return $res;
					if($res['returnStatus']['status'] == 'FAIL'){
						return 'Orgin City Is Not Valid';
					}
					else{
                    $tracking_no = substr($res['bookingReply']['result'], 22);
					}
                }

             } else {
                $manual = true;
                $source_id = 1;

                //Get Last Parcel Number
                $customer = Customer::where('id', $customer_id ->first()->id)->first();
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
                'customer_id'         => $customer_id ->first()->id,
                'shipping_partner_id' => $main_shipping_id,
                'source_id'           => $source_id,
                'province_id'         => $province_name->first()->id,
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
                'user_id'          => $company_name->first()->user_id,
                'parcel_id'        => $parcel->id,
                'parcel_status_id' => $request->status_id,
                'description'      => 'Parcel Created'
            ]);

            DB::commit();

            return 'parcel add successfully';
		 }
		 else{
			 return $validator->errors();
		 }
		 
        //try {
           // DB::beginTransaction(); 

            
        /*} catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Parcel not Added Successfully');
        }*/
	}
	
	public function filter_parcel_validate(Request $request){
		
		$filter_validate = DB::table('load_sheets')
							->join('parcels','load_sheets.tracking_id','=','parcels.tracking_id')
                            ->join('api_cities','parcels.destination_city','=','api_cities.city_name'); 
							
		if($request->from != '' && $request->to != ''){
		  $filter_validate->whereBetween('load_sheets.created_at',[$request->from,$request->to]);
		}  
		if($request->company_name != ''){ 
		  $filter_validate->where('parcels.customer_id',$request->company_name);
		}	
		if($request->parcel_no != ''){ 
		  //$filter_validate->where('parcels.change_tracking_id',$request->parcel_no);
		 $filter_validate->where('parcels.tracking_id',$request->parcel_no);
		}
       
	    return view('parcel-module.validate-parcel.filter_parcel_validate', compact('filter_validate'));
		
	}
	
	public function track_validate_parcel(Request $request){
		$data['load_sheet_status'] = 6;
		$data1['validate'] = 1;  
		$track_parcel = DB::table('load_sheets')->where('tracking_id',$request->tracking_id);
		if($track_parcel->exists()){  
			DB::table('parcels')->where('tracking_id',$request->tracking_id)->update($data1);
			$track_parcel->update($data); 
			echo '1';
		}
		else{
			echo '0';
		}	
	}

	public function weight_correction(){
		return view('parcel-module.parcel.weight_correction');
	}
	
	public function filter_weight_correction(Request $request){
		$parceldetail = DB::table('parcels');
		if($request->from != '' && $request->to != ''){
		  $parceldetail->whereBetween('created_at',[$request->from,$request->to]);
		}
		if($request->company_name != ''){
		  $parceldetail->where('customer_id',$request->company_name);
		}	
		if($request->parcel_no != ''){
		  $parceldetail->where('tracking_id',$request->parcel_no);
		}
		return view('parcel-module.parcel.filter_parcel_detail', compact('parceldetail'));
	}
	
	public function change_weight(Request $request){
		
		$final_weight = 0;
		$round_weight = round($request->weight);
		
		if($round_weight == 2 || $round_weight <! 2){   
			$final_weight = 3;
		}
		else{
			$final_weight = $round_weight; 
		}	
		$data['weight'] =  $final_weight;
		$data['weight_updated_date'] =  date('y-m-d');	
		DB::table('parcels')->where('id',$request->id)->update($data); 
		return response()->json(['status' => true, 'message' => 'Weight Updated Successfully.']);	
	}
	
	public function multi_cities(Request $request){
		$multi_citites = $request->multi_cities;
		$cities = [];
		foreach($multi_citites as $value){
			$cities[] = $value;
		}
		
		
		
	}

    public function export_parcelsss(Request $request){
        $check_exists = DB::table('parcels')->whereIn('tracking_id',$request->excel_id)->where([['export_status',0],['validate',1]]);             
          
        if($check_exists->exists()){

            return Excel::download(new validateparcel($request->excel_id), 'validateparcel.xlsx'); 
        } 
        else{
            return redirect()->back()->withInput()->with('error', 'No Record Found');
        }
    }
}
