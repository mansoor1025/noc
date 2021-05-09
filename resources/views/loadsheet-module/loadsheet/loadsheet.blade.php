@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> Add Loadsheet</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> Add Loadsheet </li>
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
                            <h3 class="panel-title">Add Loadsheet</h3>
                        </div>
                        <!-- Panel body -->
                        <form id="add-load-sheet">
                            @csrf
                            <div style="margin-left:50px;" class="panel-body"> 
                                <div class="row">

                                    <div class="col-sm-3">
                                       
                                    </div>
									
									<div class="col-sm-6">
                                         <div class="form-group">
                                            <label class="control-label">Tracking ID<span style="color: red;">*</span></label>
												<input type="number" min="0" class="form-control" name="tracking_id" id="tracking_id" placeholder="Enter Tracking ID" required/>
                                        </div>
                                    </div> 

                                    <div class="col-sm-3">
                                       
                                    </div>

                                </div>
                                
                                <div class="row">
                                    <div  class="col-xs-12 middlebutton">
                                        <button  type="submit" class="btn btn-info">Submit</button>
                                        <button type="reset" class="btn btn-danger" name="reset">Reset</button>
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
					<div id="load_sheet_result"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	$("#add-load-sheet").submit(function(e){
		e.preventDefault();
		var tracking_id = $("#tracking_id").val();
		$.ajax({
			type:"GET",
			url:'<?php echo url('/')?>/add-load-sheet',
			data:{tracking_id:tracking_id}, 
			success:function(data){
				if(data.status == 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1800
                        });
						$("#tracking_id").val('');
						view_load_sheet()
				}
				else if(data.status == 'load_exists'){
					Swal.fire({
						icon: 'error',
						title: data.message,
						showConfirmButton: false,
						timer: 1800
					});
				}
				else{  
					Swal.fire({
						icon: 'error',
						title: data.message,
						showConfirmButton: false,
						timer: 1800
					});
				}
			}
		});
	});
	
	function view_load_sheet(){ 
	  $.ajax({
		 type:'GET',
		 url:'<?php echo url('/') ?>/view-load-sheet',
		 data:{},
		 success:function(res){
			$("#load_sheet_result").html(res);
		 } 	
	  }); 
	}
	
	$(document).ready(function(){
		view_load_sheet() 
	});
</script>
@endsection
