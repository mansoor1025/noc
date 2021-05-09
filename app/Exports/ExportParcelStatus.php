<?php

namespace App\Exports;

use App\Parcel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportParcelStatus implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return new Collection([
            [
                'TcsNo',
                'Status',
            ],
            [
                '77234',
                'Out For Delivery',
            ]
        ]);
    }
}
