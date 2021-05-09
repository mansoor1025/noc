<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ExportParcelStatus;
use App\Imports\ImportParcelStatus;
use Maatwebsite\Excel\Facades\Excel;

class UpdateStatusController extends Controller
{
    public function index(){
        return view('parcel-module.update-parcel-status.update-parcel-status');
    }

    public function export() 
    {
        return Excel::download(new ExportParcelStatus, 'example.xlsx');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import() 
    {
        try {
            Excel::import(new ImportParcelStatus, request()->file('file'));
            return back()->with('message', 'Excel Data Imported successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Excel Data Not Imported successfully.');
        }
    }

}
