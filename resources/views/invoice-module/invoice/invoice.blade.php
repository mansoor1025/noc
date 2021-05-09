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
                    <a href="{{ route('create-invoice') }}"><button class="btn btn-dark" style="margin-bottom: 8px">Add Invoice</button></a>
                    <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Invoice</h3>
                        </div>
                        <div class="panel-body">
                            <table id="demo-dt-basic" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Company</th>
                                        <th>Period</th>
                                        <th>Shipping Charges</th>
                                        <th>COD Amount</th>
                                        <th>Sub Total</th>
                                        <th>Total Amount</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
 
                                <tbody>
                                    @foreach($invoices as $key=>$value)
                                        <tr>
										    
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->customer->full_name }}</td>
                                            <td>{{ $value->period->name }}</td>
                                            <td>{{ $value->shipping_charges }}</td>
                                            <td>{{ $value->cod_amount }}</td>
                                            <td>{{ $value->amount }}</td>
                                            <td>{{ $value->total_amount }}</td>
                                            <td>{{ date_format(date_create(substr($value->created_at,0,10)),"d-M-Y") }}</td>
                                            <td>
                                                <a href="{{route('view-invoice',encrypt($value->id))}}"><i class="fa fa-eye"></i></a>
                                                @if($value->post == 1)
                                                &nbsp;|&nbsp;<a href="{{route('print-invoice',encrypt($value->id))}}" target="_blank" class="btnprn"><i class="fa fa-print"></i></a>
                                                @endif
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
<script type="text/javascript">
    // $(document).ready(function(){
    //     $('.btnprn').printPage();
    // });
</script>
@endsection