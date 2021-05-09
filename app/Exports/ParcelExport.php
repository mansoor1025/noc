<?php

namespace App\Exports;

use DB;
use App\Parcel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ParcelExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $from_date;
    protected $to_date;

    function __construct($from_date,$to_date) {
            $this->from_date = $from_date;
            $this->to_date = $to_date;
    }

    public function collection()
    {
        return DB::table('parcels as p')->whereBetween('p.created_at',[$this->from_date, $this->to_date])
            ->join('parcel_statuses as ps', 'ps.id', '=', 'p.parcel_status_id')
            ->join('customers as c', 'c.id', '=', 'p.customer_id')

            ->leftJoin('parcel_logs as pl', function ($join) {
                $join->on('p.id', '=', 'pl.parcel_id')
                     ->where('pl.parcel_status_id', '=', 6);
            })

            ->select('c.full_name', 'ps.parcel_status', 'pl.created_at as arrived_at_office_date', 'p.weight', 'p.tracking_id', 'p.reference_no', 'p.user_name',
                'p.email', 'p.mobile_no', 'p.user_address', 'p.cod_amount', 'p.shipping_amount', 'p.total_amount')
            ->get();
    }

    public function headings(): array{
        return [
            'Customer Name',
            'Parcel Status',
            'Arrived At Office Date',
            'Weight',
            'Tracking_id',
            'Reference_no',
            'Username',
            'Email',
            'Mobile_no',
            'Address',
            'COD_amount',
            'Shipping Amount',
            'Total Amount'
        ];
    }
}
