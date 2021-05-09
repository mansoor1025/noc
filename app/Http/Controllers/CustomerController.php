<?php

namespace App\Http\Controllers;

use DB;
use App\Role;
use App\User;
use App\Customer;
use App\CustomerWallet;
use Illuminate\Http\Request;
use Hash;
use PDF;
use Session;
use Redirect;
use Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersrExport;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::orderBy('id', 'DESC')->get();
        return view('hr-module.customer.customer', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$bank = DB::table('bank_details')->where('status',1)->get();
		$city_list = DB::table('api_cities')->where('status',1)->get();
        return view('hr-module.customer.add',compact('bank','city_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeapi(Request $request){  
	
		$validator = Validator::make($request->json()->all(), [
				'name'             => 'required|string|min:5|max:20', 
				'company_name'     => 'required|string|unique:customers|min:5|max:20',
				'username'         => 'required|string|min:3|max:20',
				'email'            => 'required',
				'number1'          => 'required|size:11',
				'number2'          => 'required|size:11',
				'cnic'             => 'required|size:13',
				'city'             => 'required|string',
				'bank'             => 'required|string',
				'branch'           => 'required|string',
				'account_title'    => 'required|string',
				'date_of_birth'    => 'required|string',
				'anniversary_date' => 'required|string',
				'residental_address' => 'required|string',
				'shipper_address'    => 'required|string'
				]);
			
		if($validator->passes()){
			
            $user = User::create([
                'role_id'       => 3,
                'full_name'     => $request->name,
                'email'         => $request->email,
                'mobile_number' => $request->number1,
				'company_name'     => $request->company_name,
                'password'      => Hash::make($request->password),
				'show_password' => $request->password
				
            ]);
	         
			$date_of_births = date("Y-m-d", strtotime($request->date_of_birth)); 
			
		    $anniversy_date = date("Y-m-d", strtotime($request->anniversary_date));
			 
            $customer = Customer::create([
                'user_id'          => $user->id,
                'full_name'        => $request->name,
                'company_name'     => $request->company_name,
                'user_name'        => $request->username,
                'email'            => $request->email,
                'mobile_no_1'      => $request->number1,
                'mobile_no_2'      => $request->number2,
                'cnic'             => $request->cnic,
                'city'             => $request->city,
                'shipper_address'  => $request->shipper_address,
				'residental_address'  => $request->residental_address,
                'bank'             => $request->bank,
                'bank_branch'      => $request->branch,
                'account_title'    => $request->account_title,
                'birth_date'       => $date_of_births,
                'anniversary_date' => $anniversy_date,
                'agree_terms'      => 1,
                'status'           => 2
            ]);
            Customer::where('id', $customer->id)->update([
                'last_parcel_no' => $customer->id . '10000000'
            ]);

            CustomerWallet::create([
                'customer_id' => $customer->id,
                'amount'      => 0,
            ]);

            DB::commit();
			
			return redirect('/mypdfs/'.$customer->id); 
		}
		else{
				return $validator->errors();
			//return redirect('https://perfecteditings.co.uk/NOC/user-not-registered');
		}
    }

    public function store(Request $request)
    { 
		
				$validator = Validator::make($request->all(), [
					'name'             => 'required|string|min:5|max:20', 
					'company_name'     => 'required|string|unique:customers|min:5|max:20',
					'password' => 'required|between:8,255|confirmed',
					'username'         => 'required|string|min:3|max:20',
					'email'            => 'required',
					'number1'          => 'required|size:11',
					'number2'          => 'required|size:11',
					'cnic'             => 'required|size:13',
					'city'             => 'required|string',
					'banks'             => 'required|string',
					'branch'           => 'required|string',
					'account_title'    => 'required|string',
					'date_of_birth'    => 'required|string',
					'anniversary_date' => 'required|string',
					'residental_address' => 'required|string',
					'shipper_address'    => 'required|string'
					]);
			   
				if($validator->passes()){
					
					$user = User::create([
						'role_id'       => 3,
						'full_name'     => $request->name,
						'email'         => $request->email,
						'mobile_number' => $request->number1,
						'company_name'     => $request->company_name, 
						'password'      => Hash::make($request->password),
						'show_password' => $request->password
						
					]);
					 
					$date_of_births = date("Y-m-d", strtotime($request->date_of_birth)); 
					
					$anniversy_date = date("Y-m-d", strtotime($request->anniversary_date));
					 
					$customer = Customer::create([
						'user_id'          => $user->id,
						'full_name'        => $request->name,
						'company_name'     => $request->company_name,
						'user_name'        => $request->username,
						'email'            => $request->email,
						'mobile_no_1'      => $request->number1,
						'mobile_no_2'      => $request->number2,
						'cnic'             => $request->cnic,
						'city'             => $request->city,
						'shipper_address'  => $request->shipper_address,
						'residental_address'  => $request->residental_address,
						'bank'             => $request->banks,
						'bank_branch'      => $request->branch,
						'account_title'    => $request->account_title,
						'birth_date'       => $date_of_births,
						'acc_number'       => $request->acc_number, 
						'anniversary_date' => $anniversy_date,
						'agree_terms'      => 1,
						'status'           => 2
					]);
					Customer::where('id', $customer->id)->update([
						'last_parcel_no' => $customer->id . '10000000'
					]);

					CustomerWallet::create([
						'customer_id' => $customer->id,
						'amount'      => 0,
					]);

					DB::commit();
					
					return redirect('/mypdfs/'.$customer->id); 
				}
				else{
					 //return $validator->errors();
					  return redirect()->back()
					 ->withErrors($validator)
					 ->withInput();
					//return redirect('https://perfecteditings.co.uk/NOC/user-not-registered');
				}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::where('id', decrypt($id))->first();
        return view('hr-module.customer.view', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::where('id', decrypt($id))->first();
        return view('hr-module.customer.edit', compact('id', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'             => 'required|string|min:5|max:20',
            'company_name'     => 'required|string|min:5|max:20',
            'username'         => 'required|string|min:3|max:20',
            'email'            => 'required|email',
            'number1'          => 'required|size:11',
            'number2'          => 'required|size:11',
            'cnic'             => 'required|size:13',
            'city'             => 'required|string',
            'bank'             => 'required|string',
            'branch'           => 'required|string',
            'account_title'    => 'required|string',
            'date_of_birth'    => 'required|date',
            'anniversary_date' => 'required|date',
            'address'          => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $customer = Customer::where('id', decrypt($id))->first();

            $user = User::where('id', $customer->user_id)->update([
                'full_name'     => $request->name,
                'email'         => $request->email,
                'mobile_number' => $request->number1,
            ]);

            Customer::where('id', decrypt($id))->update([
                'full_name'        => $request->name,
                'company_name'     => $request->company_name,
                'user_name'        => $request->username,
                'email'            => $request->email,
                'mobile_no_1'      => $request->number1,
                'mobile_no_2'      => $request->number2,
				'password'		   => $request->password,	
                'cnic'             => $request->cnic,
                'city'             => $request->city,
                'shipper_address'  => $request->address,
                'bank'             => $request->bank,
                'bank_branch'      => $request->branch,
                'account_title'    => $request->account_title,
                'birth_date'       => $request->date_of_birth,
                'anniversary_date' => $request->anniversary_date,
                'agree_terms'      => 1,
                'status'           => 1
            ]);

            DB::commit();
            return redirect('customers')->with('message','Customer Updated successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error','Customer not Updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function changeStatus(Request $request){
      
			$data['status'] = $request->status_id;
			DB::table('customers')->where('id',$request->customer_id)->update($data);
             
            return response()->json(['status' => true, 'message' => 'Status change successfully.']);
         
        
    }
	
	public function newstoreapi(){
		 $view_bank_name = DB::table('bank_details')->where('status',1)->get(); 
		 return response()->json(['bank_detail' => $view_bank_name]);
		 
	}
	
	public function mypdf($id){ 
		Session::flush();
		$data = [ 
			'data' => $id
		];
		$pdf = PDF::loadView('hr-module.customer.myPFD', $data);
	    return $pdf->stream('invoice.pdf');  
	}
	
	 public function update_notification(){
        $data['new_notification_status'] = 1;
		$data1['notification_status'] = 1;
        DB::table('customers')->where('new_notification_status',0)->update($data);
		DB::table('load_sheets')->where('notification_status',0)->update($data1);
    }
	
	 public function change_passwords(){
         $users = DB::table('customers')->get();
         return view('change_passwords',compact('users')); 
    }

     public function user_change_password(Request $request){
		 $validator = Validator::make($request->all(), [
				 'password' => 'required|between:8,255|confirmed'
				]);
		if($validator->passes()){			 
			 $data33['password'] = Hash::make($request->password); 
			 $data33['change_password_status'] = 1;
			 $data33['show_password'] = $request->password;
			 $data33['updated_at'] = date('y-m-d');
			 DB::table('users')->where('id',$request->user_name)->update($data33);
			return redirect('change-passwords')->with('message','Password Updated successfully');
			}
		else{
		//	return $validator->errors();
			return redirect()->route('change-passwords')->withErrors(['error' => 'Password Not Matched']);
		}
    }
	 public function change_status(Request $request){
        $data['status'] = $request->value;
        DB::table('news_alerts')->where('id',$request->id)->update($data);
    }
	    public function news_alerts(){
        $news_alert =  DB::table('news_alerts')->get();
        return view('news_alerts.add_news',compact('news_alert'));
    }

    public function add_news_alerts(Request $request){

        $data['news'] = $request->add_news;
        $data['created_on'] = date('y-m-d');
        $data['created_by'] = Auth::user()->full_name;
        
        DB::table('news_alerts')->insert($data);
        return redirect('news-alerts')->with('message','News Alert Created successfully');
    }

    public function view_news_details($id){
         $news_alerts = DB::table('news_alerts')->where('id',decrypt($id))->first();
         return view('news_alerts.view_news', compact('news_alerts'));  
    }

    public function edit_news_alert($id){ 
        $news_alerts = DB::table('news_alerts')->where('id',decrypt($id))->first();
        return view('news_alerts.edit_news_alert', compact('news_alerts'));
    }

    public function update_news_alert(Request $request){ 

        $data['news'] = $request->news_alert; 
        DB::table('news_alerts')->where('id',$request->news_id)->update($data);
        return redirect('news-alerts')->with('message','News Alert Updated successfully');

    }
	
	public function export_customer_data(){ 
		 return Excel::download(new UsersrExport, 'customer.xlsx'); 
	}
	
	public function get_cities_name(){
		$default_cities = ['KARACHI','LAHORE','ISLAMABAD','PESHAWAR','QUETTA'];
		
		$spi_cities = DB::table('api_cities')->select('city_code','city_name')->where('status',1)->get(); 
		return $spi_cities;
	}
	
	public function tcs_tracking(){
		return view('parcel-module.parcel.tcs_tracking');
	}
	
	public function search_tcs_tracking(Request $request){
		
			  $arr = [
                    "userName"              => "t.pakistan",
                    "password"              => "t.pakistan1",
                    "referenceNo"           => $request->tracking_no
                ];
				$curl = curl_init();
					curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://apis.tcscourier.com/production/v1/cod/track-order",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_POSTFIELDS => json_encode($arr, JSON_FORCE_OBJECT),
                    CURLOPT_HTTPHEADER => array(
                        "x-ibm-client-id: 8e121677-f237-4ee0-955c-92d8e7bec15a"
                    ),
                ));
         
                $response = curl_exec($curl);
			
                $err = curl_error($curl);
			   
                curl_close($curl);
				$res = json_decode($response, true);
					return $res;
                if ($err) {
                    return redirect()->back()->withInput()->with('error', 'Something Getting Wrong');
                } else {
                   
                    //return $res;
					if($res['returnStatus']['status'] == 'SUCCESS'){
						echo 'heels';
						//$tracking_no = substr($res['bookingReply']['result'], 22);
					}
					else{
                       return $res['returnStatus']['message'];
					 }
				}
			echo 'dsdasds';		
	}
}
