<?php

namespace App\Exports;
use App\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersrExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection() 
    { 
        return Customer::select('full_name','company_name','mobile_no_1','mobile_no_2','cnic','City','Bank','bank_branch','account_title','birth_date','anniversary_date','residental_address','shipper_address')->where('status',2)->orderBy('id','DESC')->get();
    }
	 
	 public function headings(): array{ 
        return [ 
            'Full _name',
            'Company Name',
            'Email',
            'Mobile no 1',
            'Mobile no 2',
            'Cnic',
            'City',
            'Bank',
            'Bank Branch',
            'Account title',
            'Birth date',
            'Anniversary date',
            'Shipper address' 
        ];
    }
}