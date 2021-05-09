@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> Edit Parcel</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> Edit Parcel </li>
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
                            <h3 class="panel-title">Edit Parcel</h3>
                        </div>
                        <!-- Panel body -->
                        <form action="{{ route('update-parcel', $id) }}" method="POST">
                            @csrf
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Company <span style="color: red;">*</span></label>
                                            <select class="form-control" name="customer_id">
                                                <option selected disabled>Select Customer</option>
                                                @foreach ($customers as $value)
                                                    <option value="{{ $value->id }}" {{ $parcel->customer_id == $value->id ? 'selected' : '' }}>{{ $value->full_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('customer_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Parcel Status <span style="color: red;">*</span></label>
                                            <select class="form-control" name="status_id" disabled>
                                                @foreach ($statuses as $value)
                                                    <option value="{{ $value->id }}" {{ $parcel->parcel_status_id == $value->id ? 'selected' : '' }}>{{ $value->parcel_status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Shipping Partner <span style="color: red;">*</span></label>
                                            <select class="form-control" name="shipping_id">
                                                <option selected disabled>Select Shipping Partner</option>
                                                @foreach ($partners as $value)
                                                    <option value="{{ $value->id }}" {{ $parcel->shipping_partner_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('shipping_id')
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
                                            <label class=" control-label">Weight <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $parcel->weight ?? old('weight') }}" class="form-control" name="weight" maxlength="30" placeholder="Enter Weight" required/>
                                            @error('weight')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Tracking ID <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $parcel->tracking_id ?? old('tracking_id') }}" class="form-control" name="tracking_id" maxlength="30" placeholder="Enter Tracking ID" required/>
                                            @error('tracking_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Reference No <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $parcel->reference_no ?? old('reference_no') }}" class="form-control" name="reference_no" maxlength="30" placeholder="Enter Reference Number" required/>
                                            @error('reference_no')
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
                                            <label class=" control-label">Username <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $parcel->user_name ?? old('username') }}" class="form-control" name="username" maxlength="30" placeholder="Enter Reference Number" required/>
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Email <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $parcel->email ?? old('email') }}" class="form-control" name="email" maxlength="30" placeholder="Enter Reference Number" required/>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Mobile Number <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $parcel->mobile_no ?? old('mobile_no') }}" class="form-control" name="mobile_no" maxlength="30" placeholder="Enter Reference Number" required/>
                                            @error('mobile_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class=" control-label">User Address <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $parcel->user_address ?? old('address') }}" class="form-control" name="address" maxlength="30" placeholder="Enter Reference Number" required/>
                                            @error('address')
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
                                            <label class=" control-label">COD Amount <span style="color: red;">*</span></label>
                                            <input type="number" value="{{ $parcel->cod_amount ?? old('cod') }}" id="cod" class="form-control DropChange" name="cod" maxlength="30" placeholder="Enter COD Amount" required/>
                                            @error('cod')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Shipping Amount <span style="color: red;">*</span></label>
                                            <input type="number" value="{{ $parcel->shipping_amount ??  old('shipping_amount') }}" id="shipping" class="form-control DropChange" name="shipping_amount" maxlength="30" placeholder="Enter Shipping Amount" required/>
                                            @error('shipping_amount')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Total Amount <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $parcel->total_amount ?? old('total_amount') }}" id="total" class="form-control" name="total_amount" maxlength="30" placeholder="Total Amount" disabled/>
                                            @error('total_amount')
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
                                            <label class=" control-label">Rider Print <span style="color: red;">*</span></label>
                                            <select class="form-control" name="rider">
                                                @if($parcel->rider_print == 1)
                                                    <option value="1" selected>True</option>
                                                    <option value="0">False</option>
                                                @else
                                                    <option value="1">True</option>
                                                    <option value="0" selected>False</option>
                                                @endif
                                            </select>
                                            @error('rider')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Validate <span style="color: red;">*</span></label>
                                            <select class="form-control" name="validate">
                                                @if($parcel->validate == 1)
                                                    <option value="1" selected>True</option>
                                                    <option value="0">False</option>
                                                @else
                                                    <option value="1">True</option>
                                                    <option value="0" selected>False</option>
                                                @endif
                                            </select>
                                            @error('validate')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
$(function(){
    $(".DropChange").keyup(function() {
        var valone = $('#cod').val();
        var valtwo = $('#shipping').val();
        var total = (valone * 1) + (valtwo * 1);
        $('#total').val(total);
    });
});
</script>
@endsection