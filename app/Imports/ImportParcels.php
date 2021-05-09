<?php

namespace App\Imports;

use Auth;
use App\City;
use App\Parcel;
use App\Province;
use App\Customer;
use App\ParcelLog;
use App\WeightRange;
use App\WeightRangeCityWise;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportParcels implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try{
        //--
        $u_id = Auth::user()->id;
        $customer = Customer::where('user_id', $u_id)->first();
        //dd($customer->id);
        //dd($customer);
        $customer_id = $customer->id;

        //Get Last Parcel Number
        //$customer = Customer::where('id', $customer_id)->first();
        $tracking_no = $customer->last_parcel_no + 1;
        //--

        //$origin_city = Customer::where('id', $row['customer_id'])->first()->city;
        $origin_city = Customer::where('id', $customer_id)->first()->city;
        //dd($origin_city);

        //old get destination_city from destination_city_id
        //$destination_city = City::where('id', $row['destination_city_id'])->first()->name;
        //new directly get destination_city
        $destination_city = $row['destination_city'];
        //new get destination_city_id from destination_city name, old destination_city_id was directly given
        $destination_city_id = City::where('name', $row['destination_city'])->first()->id;

        $province_id = Province::where('id', $row['province_id'])->first()->id;

            //--
            // Check Weight is greater or less than 3
            if($row['weight'] > 3){
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
                    ['range_from', '<=', $row['weight']],
                    ['range_to', '>=', $row['weight']]
                ])->get();
            }

            //return $range; 

            // Calculate Shipping Charges
            foreach($range as $key=>$value){
                $temp = WeightRangeCityWise::where([
                    'range_id' => $range[$key]->id,
                    'city_id'  => /*$row['destination_city_id']*/$destination_city_id
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

                    if($row['weight'] > 3){
                        $diff = $row['weight'] - 3;
                        $total = ($per_kg_charges * $diff) + $shipping_amount;
                        $shipping_amount = $total;
                    }
                }
            }
            //--

        if($destination_city != 'Karachi' && $destination_city != 'Hyderabad' && $destination_city != 'Lahore'){
            if($row['weight'] > 0 && $row['weight'] <= 1){
                $username = 'DEALPAKISTAN';
                $password = 'abc123@';
                $center_code = 'DDP001';
                $service = 'O';
            } 
            else if($row['weight'] > 1 && $row['weight'] <= 3){
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
            else if($row['weight'] > 3){
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
            "consigneeName"       => $row['user_name'],
            "consigneeAddress"    => $row['user_address'],
            "consigneeMobNo"      => $row['mobile_no'],
            "consigneeEmail"      => $row['email'],
            "originCityName"      => $origin_city,
            "destinationCityName" => $destination_city,
            "weight"              => $row['weight'],
            "pieces"              => 1,
            "codAmount"           => $row['cod_amount'],
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

            Parcel::create([
                'parcel_status_id'    => 7,
                'customer_id'         => $customer_id,
                'shipping_partner_id' => 2,
                'source_id'           => 2,
                'weight'              => $row['weight'],
                'tracking_id'         => substr($res['bookingReply']['result'], 22),
                'reference_no'        => $row['reference_no'],
                'user_name'           => $row['user_name'],
                'email'               => $row['email'],
                'mobile_no'           => $row['mobile_no'],
                'user_address'        => $row['user_address'],
                'cod_amount'          => $row['cod_amount'],
                'shipping_amount'     => $shipping_amount,
                'total_amount'        => $row['cod_amount'] + $shipping_amount,
                'rider_print'         => $row['rider_print'],
                'validate'            => 0,
                'destination_city'    => $destination_city
            ]);
        }

        }//endif
        else{

            $parcel = Parcel::create([
                'parcel_status_id'    => 7, //Booking
                'customer_id'         => $customer_id,
                'shipping_partner_id' => 1,
                'source_id'           => 2,
                'weight'              => $row['weight'],
                'tracking_id'         => $tracking_no,
                'reference_no'        => $row['reference_no'],
                'user_name'           => $row['user_name'],
                'email'               => $row['email'],
                'mobile_no'           => $row['mobile_no'],
                'user_address'        => $row['user_address'],
                'cod_amount'          => $row['cod_amount'],
                'shipping_amount'     => $shipping_amount,
                'total_amount'        => $row['cod_amount'] + $shipping_amount,
                'rider_print'         => false,
                'validate'            => false,
                //'bit'                 => 0,
                'destination_city'    => $destination_city
            ]);

            Customer::where('id', $customer_id)->update([
                'last_parcel_no' => $parcel->tracking_id
            ]);

            ParcelLog::create([
                'user_id'          => Auth::user()->id,
                'parcel_id'        => $parcel->id,
                'parcel_status_id' => 7,
                'description'      => 'Parcel Created'
            ]);

        }

        } catch(\Throwable $th){
            //return response()->json(['status' => false, 'message' => 'Something Went Wrong']);

            $u_id = Auth::user()->id;
            $customer = Customer::where('user_id', $u_id)->first();
            $customer_id = $customer->id;
            $tracking_no = $customer->last_parcel_no + 1;

            $parcel = Parcel::create([
                'parcel_status_id'    => 7, //Booking
                'customer_id'         => $customer_id,
                'shipping_partner_id' => 1,
                'source_id'           => 2,
                'weight'              => $row['weight'],
                'tracking_id'         => $tracking_no,
                'reference_no'        => $row['reference_no'],
                'user_name'           => $row['user_name'],
                'email'               => $row['email'],
                'mobile_no'           => $row['mobile_no'],
                'user_address'        => $row['user_address'],
                'cod_amount'          => $row['cod_amount'],
                'shipping_amount'     => /*$shipping_amount*/0,
                'total_amount'        => $row['cod_amount'] + /*$shipping_amount*/0,
                'rider_print'         => false,
                'validate'            => false,
                //'bit'               => 0,
                'destination_city'    => $row['destination_city'],
                'province_id'          => $row['province_id']
            ]);

            Customer::where('id', $customer_id)->update([
                'last_parcel_no' => $parcel->tracking_id
            ]);

            ParcelLog::create([
                'user_id'          => Auth::user()->id,
                'parcel_id'        => $parcel->id,
                'parcel_status_id' => 7,
                'description'      => 'Parcel Created (Invalid city)'
            ]);

        }
        
    }
}
