@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> View Invoice</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> View Invoice </li>
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
                                    <h3 class="panel-title">View Invoice</h3>
                                </div>
                                <div class="col-sm-2">
                                    <input type="button" class="btn btn-info" value="Post Invoice" id="post_invoice">
                                </div>
                            </div>
                        </div>
                        <!-- Panel body -->
                        <form>
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Period</label>
                                            <select name="period" id="period" class="form-control" disabled>
                                                <option>{{ $invoice->period->name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Invoice Created At</label>
                                            <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime($invoice->created_at)) }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Company</label>
                                            <select name="customer" class="form-control" disabled>
                                                <option>{{ $invoice->customer->full_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Flyer Charges</label>
                                            <input type="text" value="{{ $invoice->flyer_charges }}" class="form-control" name="flyer_charges" placeholder="Enter Flyer Charges" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Arrear Amount</label>
                                            <input type="text" value="{{ $invoice->arrears }}" class="form-control" name="arrear" placeholder="Enter Arrear" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Deduction Amount</label>
                                            <input type="text" value="{{ $invoice->deduction }}" class="form-control" name="deduction" placeholder="Enter Deduction Amount" disabled/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">COD Amount</label>
                                            <input type="text" value="{{ $invoice->cod_amount }}" class="form-control" name="flyer_charges" placeholder="Enter Flyer Charges" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Shipping Amount</label>
                                            <input type="text" value="{{ $invoice->shipping_charges }}" class="form-control" name="arrear" placeholder="Enter Arrear" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Total Amount</label>
                                            <input type="text" value="{{ $invoice->total_amount }}" class="form-control" name="deduction" placeholder="Enter Deduction Amount" disabled/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel">
                        <!-- Panel heading -->
                        <div class="panel-heading">
                            <span class="panel-title">Parcel Details</span>
                            <button style="margin-left: 8px; margin-right:8px" class="btn btn-info" onclick="excel_invoice_parcels({{ $invoice->id }})">Excel</button>
                        </div>
                        <br>
                        <table class="table table-striped" style="margin-left: 68px; width: 92%;">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">Tracking No</th>
                                <th scope="col">Reference No</th>
                                <th scope="col">COD Amount</th>
                                <th scope="col">Shipping Amount</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Status</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->parcels as $key=>$value)    
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>{{ $value->parcel->user_name }}</td>
                                        <td>{{ $value->parcel->tracking_id }}</td>
                                        <td>{{ $value->parcel->reference_no }}</td>
                                        <td>{{ $value->parcel->cod_amount }}</td>
                                        <td>{{ $value->parcel->shipping_amount }}</td>
                                        <td>{{ $value->parcel->total_amount }}</td>
                                        <td>{{ $value->parcel->status->parcel_status }}</td>
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
