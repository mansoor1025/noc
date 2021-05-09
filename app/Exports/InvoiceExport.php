<?php

namespace App\Exports;

use DB;
use App\Invoice;
use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromArray;

//use Illuminate\Http\Request;

class InvoiceExport implements /*FromCollection*/ FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $id;
    //protected $from_date;
    //protected $to_date;

    function __construct(/*$from_date,$to_date*/ $id) {
            //$this->from_date = $from_date;
            //$this->to_date = $to_date;
            $this->id = $id;
    }

    public function array(): array
    {
        /*return DB::table('parcels as p')->whereBetween('p.created_at',[$this->from_date, $this->to_date])
            ->join('parcel_statuses as ps', 'ps.id', '=', 'p.parcel_status_id')
            ->join('customers as c', 'c.id', '=', 'p.customer_id')
            ->select('c.full_name', 'ps.parcel_status', 'p.weight', 'p.tracking_id', 'p.reference_no', 'p.user_name',
                'p.email', 'p.mobile_no', 'p.user_address', 'p.cod_amount', 'p.shipping_amount', 'p.total_amount')
            ->get();*/

        $invoice = Invoice::where('id', $this->id)->with('customer')
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
        //return json_encode($array);
        return $array;
        //$res = response()->json($array);
        //return $res;

    }

    public function headings(): array{
        return [
            'Id',
            'Date',
            'Origin',
            'Destination',
            'Weight',
            'Cod',
            'Delivery charges',
            'Status',
            'Tracking'
        ];
    }
}
