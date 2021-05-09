@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> View TCS Tracking</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> View TCS Tracking </li>
                </ol>
            </div>
        </div>
        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                                <input name="tracking_no" id="tracking_no" placeholder="Enter Tracking Tcs Number" style="border-radius: 100px; background-color:#efefef" type="text" class="form-control">
                                <button type="button" style="margin-left: 8px;" id="tcs_searching" class="btn btn-dark">Search</button>
						</div>
                    </div>
                        <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Parcel Return</h3>
                        </div>
                        <div class="panel-body">
                            <table id="demo-dt-basic" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Consignment Number</th> 
                                        <th>Customer Refernce Number</th>
                                        <th>Consignee Address</th>
										<th>Consignee Contact</th>
										<th>Consignee Email</th>
										<th>Shipment Weight</th>
										<th>Service</th>
										<th>Origin</th>
										<th>Destination</th>
										<th>Destination Country</th>
										<th>Product Detail</th>
										<th>cod Amount</th>
										<th>Destination</th>
                                    </tr>
                                </thead>
										
                                <tbody>
										<tr>
											<td colspan="14">No Data Found</td>
										</tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	$("#tcs_searching").click(function(e){
		e.preventDefault();
		var tracking_no = $("#tracking_no").val();
		$.ajax({
			type:'GET',
			url:'<?php echo url('/') ?>/search-tcs-tracking',
			data:{tracking_no:tracking_no},
			success:function(res){
				alert(res);
			}
			
		});
	})
</script>
@endsection