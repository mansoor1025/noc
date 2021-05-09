<?php

namespace App\Imports;

use App\Parcel;
use App\ParcelStatus;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportParcelStatus implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] != 'TcsNo' || $row[1] != 'Status'){
            $isExist = Parcel::where('tracking_id', $row[0])->first();
            
            if($isExist != null){
                $status = ParcelStatus::where('parcel_status', $row[1])->first();
            
                if($status){
                    Parcel::where('tracking_id', $row[0])->update([
                        'parcel_status_id' => $status->id
                    ]);
                }
            }
        }
    }
}
