@extends('layouts.main')

@section('content')
<?php  
 $company_name = DB::table('customers')->select('company_name','id')->where('status',1)->get();
?>
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i>Weight Correction Parcel</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active">Weight Correction Parcel</li>
                </ol>
            </div>
        </div>
        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <!-- Panel heading -->
                        <div class="panel-heading">
                            <h3 class="panel-title">Weight Correction</h3>
                        </div>
                        <!-- Panel body -->
                        <form id="add-load-sheet">
                            @csrf
                            <div style="margin-left:50px;" class="panel-body"> 
                                <div class="row">

                                    <div class="col-sm-3">
                                       <div class="form-group">
										<label>Parcel No</label>
										<input type="number" name="parcel_no" id="parcel_no" class="form-control">
									   </div>
                                    </div>
									
									<div class="col-sm-3">
                                       <div class="form-group">			  	
										<label>Company Name</label>
										<select name="company_name" id="company_name" class="form-control">
												<option value="">Select Company</option>
											@foreach($company_name as $value) 
												<option value="{{$value->id}}">{{$value->company_name}}</option>
											@endforeach
										</select>
									   </div>
                                    </div>
									
									<div class="col-sm-3">
									  <div class="form-group">			  	
										<label>From</label>
										<input type="date" name="from" id="from" class="form-control">
									   </div>
                                    </div>
									
									<div class="col-sm-3">
									  <div class="form-group">			  	
										<label>To</label>
										<input type="date" name="to" id="to" class="form-control">
									   </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div  class="col-xs-12 middlebutton">
                                        <button  type="button" class="btn btn-info" onclick="filter_weight_correction()">Filter</button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-left:100px;" class="row">
                            <div class="panel-footer">
                            </div>
                        </div>
                    </form>
					<br>
					<div id="validate_result" style=" overflow: auto;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
 function filter_weight_correction(){ 
	 var from = $("#from").val();
	 var to = $("#to").val();
	 var parcel_no = $("#parcel_no").val();
	 var company_name = $("#company_name").val();
	 $.ajax({
		type:'GET',
		url:'<?php echo url('/') ?>/filter-weight-correction', 
		data:{from:from,to:to,parcel_no:parcel_no,company_name:company_name},
		success:function(res){
			
			$("#validate_result").html(res);
			//console.log(res);
		}	
	 });
 }
 
 
 $(document).ready(function(){
	$("#company_name").select2();
	filter_weight_correction()
 });
</script>
@endsection
