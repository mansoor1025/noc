@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i>Loadsheet Summary</h3>
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
                            <h3 class="panel-title">Filter Loadsheet Summary</h3>
                        </div>
                        <!-- Panel body -->
                        <form id="add-load-sheet">
                            @csrf
                            <div style="margin-left:50px;" class="panel-body"> 
                                <div class="row">

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
									
									<div class="col-sm-3">
									  <div class="form-group">			  	
										<label>Parcel No</label>
										<input type="number" name="parcel_no" id="parcel_no" class="form-control">
									   </div>
                                    </div>
									
									<div class="col-sm-3">
									  <div class="form-group">			  	
										<label>loadsheet Status</label>
										<select name="load_sheet_status" id="load_sheet_status" class="form-control">
											<option value="">Select Status</option>
											<option value="6">Cleared</option>
											<option value="7">Not Cleared</option>
										</select>
									   </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div  class="col-xs-12 middlebutton">
                                        <button  type="button" id="filter_load_sheet" class="btn btn-info" onclick="filter_load_summary()">Filter</button>
                                        
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
					<div id="summary_result"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
 function filter_load_summary(){
	 var from = $("#from").val();
	 var to = $("#to").val();
	 var parcel_no = $("#parcel_no").val();
	 var load_sheet_status = $("#load_sheet_status").val();
	 $.ajax({
		type:'GET',
		url:'<?php echo url('/') ?>/filter-load-sheet',
		data:{from:from,to:to,parcel_no:parcel_no,load_sheet_status:load_sheet_status},
		success:function(res){
			$("#summary_result").html(res);
			//console.log(res);
		}	
	 });
 }
 
 $(document).ready(function(){
	filter_load_summary() 
 });
</script>
@endsection
