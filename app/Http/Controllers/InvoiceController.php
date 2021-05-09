<?php

namespace App\Http\Controllers;
use DB;
use App\Month;
use App\Parcel;
use App\Period;
use App\Invoice;
use App\Customer;
use Dompdf\Dompdf;
use PDF;
use App\InvoiceParcel;
use App\CustomerWallet;
use App\CustomerWalletLog;
use Illuminate\Http\Request;
use App\Exports\InvoiceExport;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource. 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with('period')->with('customer')->get(); 
        return view('invoice-module.invoice.invoice', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $periods = Period::all();
        $months = Month::all();
        $customers = Customer::all();
        return view('invoice-module.invoice.add', compact('periods', 'months', 'customers'));
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
            'period'        => 'required',
            'month'         => 'required',
            'year'          => 'required|digits:4',
            'customer'      => 'required',
            'flyer_charges' => 'required|numeric',
        ]);

        try {
            if($request->period == 1){
                $start_date = $request->year . "-" . $request->month . "-01" . " 00:00:00";
                $end_date = $request->year . "-" . $request->month . "-07" . " 23:59:59";
            } else if($request->period == 2){
                $start_date = $request->year . "-" . $request->month . "-08" . " 00:00:00";
                $end_date = $request->year . "-" . $request->month . "-14" . " 23:59:59";
            } else if($request->period == 3){
                $start_date = $request->year . "-" . $request->month . "-15" . " 00:00:00";
                $end_date = $request->year . "-" . $request->month . "-21" . " 23:59:59";
            } else {
                $start_date = $request->year . "-" . $request->month . "-22" . " 00:00:00";
                $end_date = $request->year . "-" . $request->month . "-31" . " 23:59:59";
            }

            /*$query = Parcel::whereBetween('created_at', [$start_date, $end_date])
                ->where('customer_id', $request->customer)->where('bit', 0);*/                  //Old
            $query = Parcel::whereBetween('created_at', [$start_date, $end_date])
                ->where('customer_id', $request->customer)->where('parcel_status_id', '!=', 7); //Only booking parcel

            // if($query == null){
            //     return redirect()->back()->withInput()->with('error', 'Data not Exist');
            // }

            $parcels = $query->get();
            $shipping_amount = $query->sum('shipping_amount');
            $cod_amount = $query->sum('cod_amount');
            $amount = $query->sum('total_amount');

            $arrear = $request->arrear ?? 0;
            $deduction  = $request->deduction ?? 0;
            $total_amount = ($amount + $request->flyer_charges) - ($arrear + $deduction);

            DB::beginTransaction();
            
            $invoice = Invoice::create([
                'customer_id'      => $request->customer,
                'payment_id'       => 1,
                'shipping_charges' => $shipping_amount,
                'cod_amount'       => 0,    //old $cod_amount,
                'amount'           => $amount,
                'total_amount'     => $total_amount,
                'payment_period'   => $request->period,
                'date'             => date('d-M',strtotime($start_date)) . '-' . date('d-M-Y', strtotime($end_date)),
                'deduction'        => $deduction,
                'arrears'          => $arrear,
                'flyer_charges'    => $request->flyer_charges,
                'post'             => 0
            ]);

            $new_cod_amount = 0;        //only delivered orders
            $new_total_cod_amount = 0;  //with all status
            $new_collectable_cod = 0;   //only delivered orders

            foreach ($parcels as $key => $parcel) {

            $new_total_cod_amount += $parcel->cod_amount;

                //check if parcel status is delivered (1) or return (5) and not include in any other invoice, then add in invoice s
                if($parcel->parcel_status_id==1 || $parcel->parcel_status_id==5){
                    $invoice_parcel_exist_count = InvoiceParcel::where('parcel_id', $parcel->id)->count();
                    if($invoice_parcel_exist_count==0){

                        if($parcel_status_id==1){
                            $new_cod_amount += $parcel->cod_amount;
                            $new_total_cod_amount += $parcel->cod_amount;
                        }

                        InvoiceParcel::create([
                            'parcel_id'  => $parcel->id,
                            'invoice_id' => $invoice->id
                        ]);

                        Parcel::where('id', $parcel->id)->update([
                            'bit' => 1
                        ]);
                    }
                }else{
                    InvoiceParcel::create([
                        'parcel_id'  => $parcel->id,
                        'invoice_id' => $invoice->id
                    ]);
                    Parcel::where('id', $parcel->id)->update([
                        'bit' => 1
                    ]);
                }
                //check if parcel status is delivered (1) or return (5) and not include in any other invoice, then add in invoice e

                /*InvoiceParcel::create([
                    'parcel_id'  => $parcel->id,
                    'invoice_id' => $invoice->id
                ]);

                Parcel::where('id', $parcel->id)->update([
                    'bit' => 1
                ]);*/   //old

            }   //end foreach

            //update newly created invoice s
                Invoice::where('invoice_id', $invoice->id)->update([
                    'cod_amount'  =>  $new_cod_amount,
                    'total_cod_amount'  =>  $new_total_cod_amount,
                    'collectable_cod'  =>  $new_collectable_cod
                ]);
            //update newly created invoice e

            DB::commit();
            return redirect('invoices')->with('message', 'Invoice Created Successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Something Went Wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::where('id', decrypt($id))->with('customer')
            ->with('period')->with('parcels.parcel.status')->first();

        //return $invoice;
        return view('invoice-module.invoice.view', compact('id', 'invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    public function postInvoice(Request $request){
        try {
            $invoice = Invoice::where('id', decrypt($request->id))->first();
            $wallet = CustomerWallet::where('customer_id', $invoice->customer_id)->first();
            
            if($invoice->post == 0){
                DB::beginTransaction();
    
                Invoice::where('id', decrypt($request->id))->update([
                    'post' => 1
                ]);
    
                CustomerWalletLog::create([
                    'customer_id' => $invoice->customer_id,
                    'invoice_id'  => $invoice->id,
                    'amount'      => $invoice->total_amount,
                    'description' => 'Invoice Post'
                ]);
    
                CustomerWallet::where('customer_id', $invoice->customer_id)->update([
                    'amount' => $wallet->amount + $invoice->total_amount
                    ]);

                DB::commit();
                return response()->json(['status' => true, 'message' => 'Invoice Post successfully.']);
            } else {
                return response()->json(['status' => false, 'message' => 'Invoice Already Posted']);
            }
            
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => 'Something Went Wrong']);
        }
    }

    public function printInvoice($id){
        $invoice = Invoice::where('id', decrypt($id))->with('customer')
            ->with('period')->with('parcels.parcel.status')->first();
		
        // dd($invoice);

        $data = [
            'title'   => 'Invoice',
            'invoice' => $invoice
        ];  
        
        $pdf = PDF::loadView('invoice-module.invoice.print', $data);
        return $pdf->stream('invoice.pdf'); 
        // return $pdf->download('medium.pdf');
        // instantiate and use the dompdf class
        // $dompdf = new Dompdf();
        // $dompdf->load_html_file('invoice-module.invoice.print');

        // (Optional) Setup the paper size and orientation
        // $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        // $dompdf->render();

        // Output the generated PDF to Browser
        // $dompdf->stream();
        // return view('invoice-module.invoice.print', compact('id', 'invoice'));
    }

    public function excelInvoice($id){
        /*$invoice = Invoice::where('id', $id)->with('customer')
            ->with('period')->with('parcels.parcel.status')->first();

        $array = array();
        //$array[0] = $invoice;
        for($i=0;$i<count($invoice->parcels);$i++){
            //echo $invoice->parcels[$i]->id;
            //echo '<br>';
            $sub_array = array();
                $sub_array['id'] = $invoice->parcels[$i]->parcel->id;
                $sub_array['date'] = $invoice->parcels[$i]->parcel->created_at;
                $sub_array['origin'] = $invoice->customer->city;
                $sub_array['destination'] = $invoice->parcels[$i]->parcel->destination_city;
                $sub_array['weight'] = $invoice->parcels[$i]->parcel->weight;
                $sub_array['cod'] = $invoice->parcels[$i]->parcel->cod_amount;
                $sub_array['delivery_charges'] = $invoice->parcels[$i]->parcel->shipping_amount;
                $sub_array['status'] = $invoice->parcels[$i]->parcel->status->parcel_status;
                $sub_array['tracking'] = $invoice->parcels[$i]->parcel->tracking_id;
            $array[$i] = $sub_array;
        }
        //return response()->json(json_encode($array));
        $res = response()->json($array);
        return $res;*/

        return Excel::download(new InvoiceExport($id), 'invoice.xlsx');

    }

}
