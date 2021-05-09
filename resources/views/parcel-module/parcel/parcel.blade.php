@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> View Parcel</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> View Parcel </li>
                </ol>
            </div>
        </div>
        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row" style="margin-top: -15px">
                        <div class="col-sm-3">
                            <a href="{{ route('create-parcel') }}"><button class="btn btn-dark" style="margin-bottom: 8px">Add Parcel</button></a>
                        </div>

                        @if(Auth::user()->role_id!=1)

                        <div class="col-sm-9">
                            <div style="display: flex">
                                <form style="display: flex" action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input style="border-radius: 100px; background-color:#efefef" type="file" name="file" class="form-control">
                                    <button style="margin-left: 8px; margin-right:8px" class="btn btn-dark">Import Parcels</button>
                                </form>
                                <a href="{{ route('export') }}"><button style="margin-right: 8px" class="btn btn-dark">Export Examples</button></a>
                            </div>
                        </div>

                        @endif

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <form style="display: flex" action="{{ route('export-parcel-data') }}" method="POST">
                                @csrf
                                <label class="">From Date</label>
                                <input type="date" name="from_date" class="form-control">
                                <label>To Date</label>
                                <input type="date" name="to_date" class="form-control">
                                <button style="margin-left: 8px; margin-right:8px;" class="btn btn-dark">Export Parcel</button>
                            </form>
                        </div>
                    </div>
                    <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title">All Parcels</span>
                            <button style="margin-left: 8px; margin-right:8px" class="btn btn-dark" onclick="print_multiple_invoice_redirect()">Print Selectd Parcels</button>
							
                            <button style="margin-left: 8px; margin-right:8px; margin-top: 1px;" class="btn btn-dark" id="checkAll">Select All</button>
                        </div>
                        <div class="panel-body">
                            <table id="demo-dt-basic" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Print</th>
                                        <th class="sorting_desc" aria-sort="descending" aria-label="S.No: activate to sort column ascending">S.No</th>
                                        <th>Company</th>
                                        @if(Auth::user()->role_id==1)<th>Shipping Partner</th>@endif
                                        <th>Reference No</th>
                                        <th>Consignee Address</th>
                                        <th>Tracking ID</th>
										<th>Weight</th>
                                        <th>Total Amount</th>
                                        <th>Date</th>
                                        <th>Destination</th>
                                        <th>Parcel Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
								    <?php $testing_array = []; ?>
                                    @foreach($parcels as $key=>$value)
									    <?php $testing_array[] = $value->parcel_status_id.'_'.$value->id ?>
                                        <tr>
										     
                                            <td><input type="checkbox" id="print_multiple_invoice" class="tester" name="print_multiple_invoice" value="{{ $value->id }}"></td>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->customer->full_name }}</td>
                                            @if(Auth::user()->role_id==1)<td>{{ $value->partner->name }}</td>@endif
                                            <td>{{ $value->reference_no }}</td>
                                            <td>{{ $value->user_address }}</td>
                                            <td>{{ $value->tracking_id }}</td>
											<td>{{ $value->weight }}</td> 
                                            <td>{{ $value->total_amount }}</td>
                                            <td>{{ date_format(date_create(substr($value->created_at,0,10)),"d-M-Y") }}</td>
                                            <!--<td>{{ $value->destination_city }}</td>-->
											<td> 
												<select disabled  class="form-control" name="city_id" onchange="changeCityBookParcel({{$value->id}}, this.value)">
													<!--<option selected disabled>Select</option>-->
													<option selected disabled>{{ $value->destination_city }}</option>
												   
												</select>
												@error('city_id')
													<span class="invalid-feedback" role="alert">
														<p class="text-danger">{{ $message }}</p>
													</span>
												@enderror
											</td>
 
                                            <td> 
                                                <select class="form-control statuss" name="status"  @if(Auth::user()->id !=1) @if($value->parcel_status_id == 8) disabled @endif @endif >
                                                    @foreach($statuses as $status)
                                                        <option value="{{$status->id}}-{{ $value->id }}" {{ $value->parcel_status_id == $status->id ? 'selected' : '' }}  >{{ $status->parcel_status }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
											
                                            <td>
                                                <a href="{{route('view-parcel',encrypt($value->id))}}"><i class="fa fa-eye"></i></a>&nbsp;|&nbsp;
                                                <a href="{{route('edit-parcel',encrypt($value->id))}}"><i class="fa fa-pencil"></i></a>&nbsp;|&nbsp;
                                                <a href="{{route('print-parcel',encrypt($value->id))}}"><i class="fa fa-print"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('.statuss').select2();
    });

    $(document).ready(function() {
        $('.statuss').change(function() {
            var ids = $(this).val(); 
			var idss = ids.split("-");
			var status_id = idss[0];
			var parcel_id = idss[1];
			
            //var dataString = 'status_id='+ ids[1] +'&parcel_id='+ ids[4];  
            $.ajax({
                type: "GET",
                url: "{{ route('change-status') }}",
                data: {status_id:status_id,parcel_id:parcel_id},
                cache: false,
                success: function(data){
					
                    if(data.status == true){
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
					location.reload(); 
                } 
            });
        })
		
    });

    var print_multiple_invoice_arrays = [];
    function print_multiple_invoice(id){
        print_multiple_invoice_array.push(id);
		var sList = "";
		$('.tester').each(function () {
			sList += "(" + $(this).val() + "-" + (this.checked ? "checked" : "not checked") + ")";
		});
		console.log (sList);
        //alert(print_multiple_invoice_array);
        //window.open("print_multiple_invoice/"+JSON.stringify(print_multiple_invoice_array), "_blank");
        //print_multiple_invoice_redirect();
    }

    function print_multiple_invoice_redirect(){
		
        //window.open("print_multiple_invoice/"+JSON.stringify(print_multiple_invoice_array), "_blank");
        //window.open("print_multiple_invoice/"+JSON.stringify(print_multiple_invoice_array),"_self");
		var sList = "";
		$('.tester').each(function () {
			if (this.checked) {
			    id = $(this).val();
				print_multiple_invoice_arrays.push(id)
			}
			//alert($(this).val()); 
			//	sList += "(" + $(this).val() + "-" + (this.checked ? "checked" : "not checked") + ")";
			
			 
		});
		//console.log (sList);
        window.location.replace("print_multiple_invoice/"+JSON.stringify(print_multiple_invoice_arrays));
        print_multiple_invoice_arrays = [];
    }

    function changeCityBookParcel(parcel_id, city_id){
        //alert(parcel_id + city_id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $.ajax({
                type: "POST",
                url: "{{ route('city-change-parcel-book') }}",
                data:{
                    parcel_id:parcel_id,
                    city_id:city_id
                },
                cache: false,
                success: function(data){
                    //alert(data);
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated successfully.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    /*if(data.status == true){
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }*/
					
                } 
            });
    }
	 
	
	$('#checkAll').click(function(){
		var d = $(this).data(); // access the data object of the button
		$(':checkbox').prop('checked', !d.checked); // set all checkboxes 'checked' property using '.prop()'
		d.checked = !d.checked; // set the new 'checked' opposite value to the button's data object
	});
	
	

</script>
@endsection