@extends('layouts.main')

@section('content')
<?php
 $cities = [];	
 $api_cities = DB::table('api_cities')->where('status',1)->get();  
 $company_name = DB::table('customers')->select('company_name','id')->where('status',1)->get();
 $parcel_cities = DB::table('parcels')->select('destination_city')->where([['validate',1],['export_status',0],['shipping_partner_id',1]])->get();
 foreach($parcel_cities as $value){
	 $cities[] = $value->destination_city;
 }
?>
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog " role="document">
      <!--Content-->
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header">
          <p class="heading lead">Export Parcel</p>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="white-text">×</span>
          </button>
        </div>
	 <form action="{{url('/')}}/multi-cities" method="POST">
        @csrf
		<!--Body-->
        <div class="modal-body">
			 <div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					 <div class="form-group">
						<label>Select Multiple Cities
						<select name="multi_cities[]" id="multi_cities" class="form-control" multiple>
						 <option value="">Select Cities</option>
						  @foreach($api_cities as $value)
						  <option value="{{$value->city_name}}" <?php if (in_array($value->city_name, $cities)) echo 'selected'; ?> >{{$value->city_name}}</option>
						  @endforeach
						</select>
						</label>
					 </div>
			   </div>
			</div>
        </div>

        <!--Footer-->
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-success waves-effect waves-light">Get Export 
            <i class="far fa-gem ml-1"></i> 
          </button>
        </div>
	 </form>	
      </div>
      <!--/.Content-->
    </div>
</div>
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i>Validate Parcel</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active">Loadsheet Summary</li>
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
                            <h3 class="panel-title">Validate Parcel</h3>
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
                                        <button  type="button" class="btn btn-info" onclick="filter_validate_parcel()">Filter</button>
                                        
                                    </div>
                                </div>
								<div class="row">
									<div class="col-lg-3">
										
									</div>
									<div class="col-lg-6">
										<input type="number" min="0" id="tracking_id" class="form-control" placeholder="Search Tracking ID" >
										<p id="error_track" style="color: red;"><b></b></p>
									</div>
									<div class="col-lg-3"> 
										<button type="button" class="btn btn-success" onclick="validate_parcel()">validate</button>
										<button type="button" class="btn btn-success" onclick="export_excel()">Export Excel</button>
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
					<div id="validate_result"></div>
                </div>
            </div>
        </div>
    </div>
</div>
	
<script>
 function filter_validate_parcel(){ 
	 var from = $("#from").val();
	 var to = $("#to").val();
	 var parcel_no = $("#parcel_no").val();
	 var company_name = $("#company_name").val();
	 $.ajax({
		type:'GET',
		url:'<?php echo url('/') ?>/filter-parcel-validate', 
		data:{from:from,to:to,parcel_no:parcel_no,company_name:company_name},
		success:function(res){
			$("#validate_result").html(res);
			
		}	
	 });
 }
 
 function validate_parcel(){
	var tracking_id = $("#tracking_id").val();
	$.ajax({
		type:'GET',
		url:'<?php echo url('/') ?>/track-validate-parcel', 
		data:{tracking_id:tracking_id},
		success:function(res){
			if(res == 1){
				filter_validate_parcel();
				$("#error_track").html('');
				$("#tracking_id").val('');
			}
			else{
				$("#error_track").html('Tracking Doesnt Exists');
			}
		}	
	 });
 }
 
 $(document).ready(function(){
	$("#company_name").select2();
	filter_validate_parcel()
	$("#multi_cities").select2();
 });
 
 function export_excel(){  
	var excel_id = [];
	var tcs_id = [];
	$('input[name="noc_check_box"]:checked').each(function() {
		tcs_id.push(this.value);
	}); 

	$("input:checkbox:not(:checked)").each(function() {
       excel_id.push(this.value); 
	}); 

	$.ajax({
		type:'GET',
		url:'<?php echo url('/') ?>/export-parcels',
		data:{excel_id:excel_id,tcs_id:tcs_id},
		success:function(res){
			//location.reload()
		}
	});
 }
 

</script>
@endsection
