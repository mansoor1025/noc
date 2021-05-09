<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use DB; 
class BankController extends Controller
{
   function addBankDetails(){
       $view_bank_name = DB::table('bank_details')->where('status',1)->get();

   	   return view('bank-details.addBankDetails',compact('view_bank_name')); 
   }

   function saveBankDetails(Request $request){
   	  $branch_code = $request->branch_code;
      $bank_name   = $request->bank_name;

      $data['branch_code'] = $branch_code;
      $data['bank_name'] =   $bank_name;
	  $data['created_on'] =  date('y-m-d');

      DB::table('bank_details')->insert($data); 
      return redirect('add-bank-details')->with('message', 'Your Bank Details Updated Successfully');

   }

   function view_bank_details($id){
   	 $view_bank_detail = DB::table('bank_details')->where('id',decrypt($id))->first();
   	 return view('bank-details.view_bank_details',compact('view_bank_detail'));
   }

   function edit_bank_details($id){
   	 $edit_bank_detail = DB::table('bank_details')->where('id',decrypt($id))->first();
   	 return view('bank-details.edit_bank_details',compact('edit_bank_detail')); 
   }

   function update_bank_details(Request $request){
   
   	  $branch_code = $request->branch_code;
      $bank_name   = $request->bank_name;

      $data['branch_code'] = $branch_code;
      $data['bank_name'] =   $bank_name;
	  $data['created_on'] =  date('y-m-d');

      DB::table('bank_details')->where('id',$request->bank_id)->update($data); 
      return redirect('add-bank-details')->with('message', 'Your Bank Details Updated Successfully');
   }
}
