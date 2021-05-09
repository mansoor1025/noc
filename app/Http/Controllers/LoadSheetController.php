<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDF;
use Auth;
use App\Invoice;
use App\Period;
use App\Month;
use App\Customer;
use App\Parcel;
use App\LoadSheet;
use App\LoadSheetParcel;

class LoadSheetController extends Controller
{

    public function index()
    {
        //$loadsheets = Invoice::with('period')->with('customer')->get();
        //return view('invoice-module.invoice.invoice', compact('invoices'));
        
        //
        $u_id = Auth::user()->id;
        $customer = Customer::where('user_id', $u_id)->first();
        $customer_id = $customer->id;
        //
        $loadsheets = LoadSheet::where('customer_id','=',$customer_id)->orderBy('created_at', 'DESC')->get();
        return view('loadsheet-module.loadsheet.loadsheet', compact('loadsheets'));
    }

    public function create(){
    	/*$periods = Period::all();
        $months = Month::all();
        $customers = Customer::all();
        return view('loadsheet-module.loadsheet.add', compact('periods', 'months', 'customers'));*/
        return view('loadsheet-module.loadsheet.add');
    }

    public function store(Request $request){
		
    	//return 'add';
        $u_id = Auth::user()->id;
        $customer = Customer::where('user_id', $u_id)->first();
        $customer_id = $customer->id;
		
		$check_exists = DB::table('parcels')->where([['tracking_id',$request->tracking_id],['customer_id',$customer_id]]);
		if($check_exists->exists()){
			$check_load_sheet = DB::table('load_sheets')->where('tracking_id',$request->tracking_id);
			if($check_load_sheet->exists()){ 
				return response()->json(['status'=>'load_exists', 'message'=>'Already exists in load sheet']);
			}else{
				$loadSheet = LoadSheet::create([
					'customer_id'   =>  $customer_id,
					'tracking_id'   => $request->tracking_id,
					'user_id'       => Auth::user()->id,
					'created_at'    =>  date('y-m-d'),
				]);
				return response()->json(['status'=>'success', 'message'=>'Load Sheet Created Successfully.']);
			}
		}
		else{
			return response()->json(['status'=>false, 'message'=>'Sorry this Tracking ID Doesnt Exists.']);
		}
		
        //return redirect('load-sheet')->with('message', 'Load Sheet Created Successfully');
    }

    public function view($id){
        /*$invoice = Invoice::where('id', $id)->with('customer')
            ->with('period')->with('parcels.parcel.status')->first();
        return view('loadsheet-module.loadsheet.view', compact('id', 'invoice'));*/
        $loadsheet = LoadSheet::where('id', $id)->with('customer')->with('loadsheet_parcels.parcel')->first();
        //return $loadsheet;
        return view('loadsheet-module.loadsheet.view', compact('id', 'loadsheet'));
    }

    public function scanParcel(Request $request){
        try {

            /*$isExist = Parcel::where('tracking_id', $request->tracking_id)->update([
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

            return view('parcel-module.validate-parcel.validate' ,compact('parcel'));*/

            $parcel = Parcel::where('tracking_id', $request->tracking_id)/*->with('customer')->with('partner')*/->first();
            $parcel_id = $parcel->id;

            LoadSheetParcel::where('load_sheet_id', $request->load_sheet_id)->where('parcel_id', $parcel_id)->update(['scan' => 1]);

            $loadsheet = LoadSheet::where('id', $request->load_sheet_id)->with('customer')->with('loadsheet_parcels.parcel')->first();
            $id = $request->load_sheet_id;  //for compact only
            return view('loadsheet-module.loadsheet.view', compact('id', 'loadsheet'));

        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Something Went Wrong');
        }
    }

    public function print($id){
    	//return 'print';

        /*$invoice = Invoice::where('id', decrypt($id))->with('customer')
            ->with('period')->with('parcels.parcel.status')->first();
        // dd($invoice);
        $data = [
            'title'   => 'Invoice',
            'invoice' => $invoice
        ];
        $pdf = PDF::loadView('invoice-module.invoice.print', $data);
        return $pdf->stream('invoice.pdf');*/

        $loadsheet = LoadSheet::where('id', $id)->with('customer')->with('loadsheet_parcels.parcel')->first();
        $data = [
            'title'   => 'Loadsheet',
            'loadsheet' => $loadsheet
        ];
        //return $loadsheet;
        $pdf =  PDF::loadView('loadsheet-module.loadsheet.print', $data);
        return $pdf->stream('loadsheet.pdf');

    }
	
	public function view_load_sheet(Request $request){
		$load_sheet = DB::table('load_sheets')->where('status',1)->get();
		$customer_id = [];
		$tracking_id = [];
		foreach($load_sheet as $value){
			$customer_id[] = $value->customer_id;
			$tracking_id[] = $value->tracking_id;
		}
		
		$parcel_detail = DB::table('parcels') 
							->whereIn('customer_id',$customer_id)
							->whereIn('tracking_id',$tracking_id)
							->get(); 
        $company_name = DB::table('customers')->where('user_id',Auth::user()->id)->first()->company_name;								
		return view('loadsheet-module.loadsheet.view_load_sheet',compact('parcel_detail','company_name'));
	}
	
	public function load_sheet_process(Request $request){ 
		$data['status'] = 2;
		$u_id = Auth::user()->id;
        $customer = Customer::where('user_id', $u_id)->first();
        $customer_id = $customer->id;
		DB::table('load_sheets')->where('customer_id',$customer_id)->update($data);
		return response()->json(['status'=>'success', 'message'=>'Load Sheet Transfer To Validate Parcels.']);
		
	}
	 
	public function print_load_Sheet(Request $request){ 
		$tracking_id = explode("_",$request->check_array);
		$track_array = []; 
		foreach($tracking_id as $value){
			if($value != ''){
				$track_array[] = $value; 
			}
		}
		
		$load_sheets = DB::table('load_sheets')
							->select('load_sheets.tracking_id','parcels.user_name','parcels.destination_city','parcels.cod_amount','load_sheets.created_at')
							->join('parcels','load_sheets.tracking_id','=','parcels.tracking_id')
							->whereIn('load_sheets.tracking_id',$track_array)
							->where('load_sheets.status',2)
							->get();
		
	    $myJSON = json_encode($load_sheets);
		return $myJSON;  
		//$load_sheets = DB::table('load_sheets')->where([['customer_id',$customer_id],['status',1]])->get();
		//return view('loadsheet-module.loadsheet.print_load_Sheet');
	}

	public function load_sheet_summary(){
		return view('loadsheet-module.loadsheet.load_sheet_summary');
	}
	
	public function filter_load_sheet(Request $request){
		$filter_sheet = DB::table('load_sheets')
							->where('user_id',Auth::user()->id);
		if($request->from != '' && $request->to != ''){
			
		 $filter_sheet->whereBetween('created_at',[$request->from,$request->to]);
		}
		if($request->parcel_no != ''){
			$filter_sheet->where('tracking_id',$request->parcel_no);
		}
	    if($request->load_sheet_status != ''){
			$filter_sheet->where('load_sheet_status',$request->load_sheet_status);
		}   
		return view('loadsheet-module.loadsheet.filter_load_sheet',compact('filter_sheet'));
		
	}
}