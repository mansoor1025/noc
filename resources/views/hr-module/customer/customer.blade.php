@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> View Customer</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> View Customer </li>
                </ol>
            </div>
        </div>
        <!--Page content-->
        <!--===================================================-->
		<div class="row">
			<div class="col-sm-12">
				<form style="display: flex" action="{{ route('export-customer-data') }}" method="POST">
					@csrf
					
					<button style="margin-left: 8px; margin-right:8px" class="btn btn-dark">Export Customers</button>
					<a href="{{ route('create-customer') }}"><button type="button" class="btn btn-dark" style="margin-bottom: 8px">Add Customer</button></a>
				</form>
			</div>
		</div>
        <div id="page-content">
            <div class="row">
                <div class="col-lg-12">
                    
                    <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Customer</h3>
                        </div>
                        <div class="panel-body">
                            <table id="demo-dt-basic" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Company Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($customers as $key=>$value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->full_name }}</td>
                                            <td>{{ $value->company_name }}</td>
                                            <td>{{ $value->email }}</td>
                                            <td>{{ $value->mobile_no_1 }}</td>
                                            <td>{{ $value->shipper_address }}</td>
                                            <td>
                                                {{-- <input data-id="{{$value->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $value->status ? 'checked' : '' }}> --}}
                                                <select class="form-control status" name="status">
                                                    <option value="0_{{  $value->id }}" {{ $value->status == 0 ? 'selected' : '' }}>Inactive</option>
                                                    <option value="1_{{  $value->id }}" {{ $value->status == 1 ? 'selected' : '' }}>Active</option>
                                                    <option value="2_{{  $value->id }}" {{ $value->status == 2 ? 'selected' : '' }}>New</option>
                                                </select>
                                            </td>
                                            <td>
                                                <a href="{{route('view-customer',encrypt($value->id))}}"><i class="fa fa-eye"></i></a>&nbsp;|&nbsp;
                                                <a href="{{route('edit-customer',encrypt($value->id))}}"><i class="fa fa-pencil"></i></a>&nbsp;|&nbsp;
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
        $('.status').change(function() {
            var ids = $(this).val();
			var idss = ids.split("_");
			var status_id = idss[0];
			var customer_id = idss[1];
			
            var dataString = 'status='+ ids[1] +'&customer_id='+ ids[4];
            $.ajax({
                type: "GET",
                url: "{{ route('changeCustomerStatus') }}",
                data: {status_id:status_id,customer_id:customer_id},
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
                } 
            });
        })
    })
    // $(document).on('change', '.toggle-class' , function() {
    //     var status = $(this).prop('checked') == true ? 1 : 0; 
    //     var customer_id = $(this).data('id');
    //     var $this = $(this);
        
    //     $.ajax({
    //         type: "GET",
    //         dataType: "json",
    //         url: '{{ route('changeCustomerStatus') }}',
    //         data: {'status': status, 'customer_id': customer_id},
    //         success: function(data){
    //             if(data.status == true){
    //                 Swal.fire({
    //                 //   position: 'top-end',
    //                     icon: 'success',
    //                     title: data.message,
    //                     showConfirmButton: false,
    //                     timer: 3000
    //                 });
    //             }
    //             else{
    //                 $this.parent('.toggle').removeClass('btn btn-danger off');
    //                 $this.parent('.toggle').addClass('btn btn-success');
    //                 Swal.fire({
    //                 //   position: 'top-end',
    //                     icon: 'error',
    //                     title: data.message,
    //                     showConfirmButton: false,
    //                     timer: 3000
    //                 });
    //             }
    //         }
    //     });
    // })
</script>
@endsection