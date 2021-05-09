<?php

namespace App\Exports;
use App\Customer;
use DB;  
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; 

class validateparcel implements FromCollection , WithHeadings
{

    /**
    * @return \Illuminate\Support\Collection
    */

	 function __construct($id) {
			$this->ids = $id;
	 }
    public function collection() 
    { 
         
	    $data['export_status'] = 1;  
		$datas = DB::table('parcels')->select('user_name','user_address','mobile_no','email','destination_city','pieces','weight','cod_amount','tracking_id','special_handling','service_type','product_detail')->whereIn('tracking_id',$this->ids)->where([['shipping_partner_id',1],['export_status',0]])->orderBy('id','asc')->get();
		DB::table('parcels')->whereIn('tracking_id',$this->ids)->update($data); 
		return $datas;	 
	}  
	 
	 public function headings(): array{ 
        return [ 
            'Consignee Name',
            'Consignee Address',
            'Consignee Mobile Number',
            'Consignee Email',
            'Destination City',
            'Pieces',
            'Weight',
            'COD Amount', 
            'Customer Reference Number',
			'Special Handling',
            'Service Type',
			'Product Detail',
           
        ];
    }
}