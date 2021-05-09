@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> Add Customer Wallet</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> Add Customer Wallet </li>
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
                            <h3 class="panel-title">Add Customer Wallet</h3>
                        </div>
                        <!-- Panel body -->
                        <form action="{{ route('add-customer-wallet') }}" method="POST">
                            @csrf
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row"> 
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Company <span style="color: red;">*</span></label>
                                            <select name="customer" id="customer" class="form-control">
                                                <option disabled selected>Select Customer</option>
                                                @foreach ($customers as $key=>$customer)
                                                    <option value="{{ $customer->id }}" id="{{ $customer->id }}">{{ $customer->full_name }}</option> 
                                                @endforeach
                                            </select>
                                            @error('customer')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Wallet Amount <span style="color: red;">*</span></label>
                                            <input type="text" id="wallet_amount" class="form-control" placeholder="Wallet Amount" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Amount <span style="color: red;">*</span></label>
                                            <input type="text" id="amount" value="{{ old('amount') }}" class="form-control" name="amount" placeholder="Enter Amount" required/>
                                            @error('amount')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Type <span style="color: red;">*</span></label>
                                            <select name="type" id="type" class="form-control">
                                                <option disabled selected>Select</option>
                                                <option value="1" id="1">Advance</option> 
                                                <option value="2" id="2">Other</option> 
                                            </select>
                                            @error('type')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-8" style="display: none" id="description">
                                        <div class="form-group">
                                            <label class=" control-label">Description <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('description') }}" id="description" class="form-control" name="description" placeholder="Enter Description"/>
                                            @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div  class="col-xs-12 middlebutton">
                                        <button id="submit" type="submit" class="btn btn-info">Submit</button>
                                        <button type="reset" class="btn btn-danger" name="reset">Reset</button>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-left:100px;" class="row">
                                <div class="panel-footer">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $('#customer').change(function(){
        var customer_id = $(this).children(":selected").attr("id");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '{{ route('getWallet') }}',
            data: {'status': status, 'customer_id': customer_id},
            success: function(data){
                if(data.status){
                    $('#wallet_amount').val(data.value);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            }
        })
      
    });

    $('#type').change(function(){
        var id = $(this).children(":selected").attr("id");
        if(id == 2){
            document.getElementById("description").style.display = "block";
        } else {
            document.getElementById("description").style.display = "none";
        }
    });

    // $('#amount').keyup(function(){
    //     var amount = parseInt(document.getElementById('amount').value);
    //     var wallet_amount = parseInt(document.getElementById('wallet_amount').value);
    //     if(wallet_amount != null){
    //         if(amount <= wallet_amount){
    //             return true;
    //         } else {
    //             if(amount != null){
    //                 Swal.fire({
    //                     icon: 'warning',
    //                     title: 'You Enter More Amount than Wallet',
    //                     showConfirmButton: true,
    //                     timer: 3000
    //                 });
    //             }
    //             return false;
    //         }
    //     } else {
    //         Swal.fire({
    //             icon: 'warning',
    //             title: 'Please Select Customer First',
    //             showConfirmButton: false,
    //             timer: 3000
    //         });
    //     }
    // })
</script>
@endsection
