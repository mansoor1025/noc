@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> View Load Sheet</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> View Load Sheet </li>
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
                            <div class="row">
                                <div class="col-sm-10">
                                    <h3 class="panel-title">Load Sheet # <b>{{$loadsheet->id}}</b></h3>
                                </div>
                                <!--<div class="col-sm-2">
                                    <input type="button" class="btn btn-info" value="Post Invoice" id="post_invoice">
                                </div>-->
                            </div>
                        </div>
                        <!-- Panel body -->
                        <!--<form>-->
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row">
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Start Date</label>
                                            <input type="text" class="form-control" value="{{ date('d M Y', strtotime($loadsheet->start_date)) }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">End Date</label>
                                            <input type="text" class="form-control" value="{{ date('d M Y', strtotime($loadsheet->end_date)) }}" disabled>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <form style="display:flex" action="{{ route('scan-load-sheet-parcel') }}" method="POST">
                                            @csrf
                                            <input name="load_sheet_id" style="display:none;" type="text" value="{{$loadsheet->id}}">
                                            <input name="tracking_id" placeholder="Scan parcel" style="border-radius: 100px; background-color:#efefef" type="text" class="form-control">
                                            <button type="submit" style="margin-left: 8px;" class="btn btn-dark">Scan</button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        <!--</form>-->
                    </div>
                    <div class="panel">
                        <!-- Panel heading -->
                        <div class="panel-heading">
                            <span class="panel-title">Load Sheet Parcel Details</span>
                            
                        </div>
                        <br>
                        <table class="table table-striped" style="margin-left: 68px; width: 92%;">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <!--<th scope="col">Username</th>-->
                                <th scope="col">Tracking No</th>
                                <th scope="col">Shipper name</th>
                                <th scope="col">User name</th>
                                <th scope="col">City</th>
                                <!--<th scope="col">Reference No</th>
                                <th scope="col">COD Amount</th>
                                <th scope="col">Shipping Amount</th>-->
                                <th scope="col">Total Amount</th>
                                <th scope="col">Weight</th>
                                <th scope="col">Scan</th>
                                <!--<th scope="col">Date</th>-->
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($loadsheet->loadsheet_parcels as $key=>$value)
                                    <tr @if($value->scan==1) style="background-color:#CCFFCC;" @endif>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <!--<td>{{ $value->parcel->user_name }}</td>-->
                                        <td>{{ $value->parcel->tracking_id }}</td>
                                        <td>{{ $loadsheet->customer->company_name }}</td>
                                        <td>{{ $value->parcel->user_name }}</td>
                                        <td>{{ $value->parcel->destination_city }}</td>
                                        <!--<td>{{ $value->parcel->reference_no }}</td>
                                        <td>{{ $value->parcel->cod_amount }}</td>
                                        <td>{{ $value->parcel->shipping_amount }}</td>-->
                                        <td>{{ $value->parcel->total_amount }}</td>
                                        <td>{{ $value->parcel->weight }}</td>
                                        <td>{{ $value->scan }}</td>
                                        <!--<td>{{ date('d M Y', strtotime($value->parcel->created_at)) }}</td>-->
                                    </tr>
                                @endforeach
                            </tbody>
                          </table>
                    </div>
                    <div style="margin-left:100px;" class="row">
                        <div class="panel-footer">
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
$('#post_invoice').click(function(){
    var id = '{{ $id }}'
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Post it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('post-invoice') }}',
                data: {'id': id},
                success: function(data){
                    if(data.status == true){
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Invoice did not Post',
                showConfirmButton: true,
                timer: 1500
            })
        }
    })
})

    function excel_invoice_parcels(id){
        //alert(id);
        window.location.replace("../excel-invoice/"+id);
    }

</script>
@endsection
