<?php

namespace App\Exports;

use App\Parcel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
class ParcelsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return new Collection([
            [
                'parcel_status_id',
                'customer_id',
                'shipping_partner_id',
                'source_id',
                'weight',
                'tracking_id',
                'reference_no',
                'user_name',
                'email',
                'mobile_no',
                'user_address',
                'cod_amount',
                'shipping_amount',
                'total_amount',
                'rider_print',
                'validate'
            ],
            [
                1,
                2,
                2,
                1,
                12,
                'ABC123',
                1234,
                'Testing',
                'email@mail.com',
                '03471828282',
                'karachi, Pakistan',
                12,
                12,
                24,
                1,
                1
            ]
        ]);
    }
}
