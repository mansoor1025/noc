@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> Add Parcel</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> Add Parcel </li>
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
                            <h3 class="panel-title">Add Parcel</h3>
                        </div>
                        <!-- Panel body -->
                        <form action="{{ route('add-parcel') }}" method="POST">
                            @csrf
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Company <span style="color: red;">*</span></label>
                                            <select class="form-control" name="customer_id">
                                                <option selected disabled>Select Customer</option>
                                                @foreach ($customers as $value)
                                                    <option value="{{ $value->id }}">{{ $value->full_name }}</option>
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
                                            <select class="form-control" name="status_id">
                                                <option selected disabled>Select Status</option>
                                                @foreach ($statuses as $value)
                                                    <option value="{{ $value->id }}">{{ $value->parcel_status }}</option>
                                                @endforeach
                                            </select>
                                            @error('status_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Shipping Partner <span style="color: red;">*</span></label>
                                            <select class="form-control" name="shipping_id">
                                                <option selected disabled>Select Shipping Partner</option>
                                                @foreach ($partners as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
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
                                            <input type="text" value="{{ old('weight') }}" class="form-control" name="weight" maxlength="30" placeholder="Enter Weight" required/>
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
                                            <input type="text" value="{{ old('tracking_id') }}" class="form-control" name="tracking_id" maxlength="30" placeholder="Enter Tracking ID" required/>
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
                                            <input type="text" value="{{ old('reference_no') }}" class="form-control" name="reference_no" maxlength="30" placeholder="Enter Reference Number" required/>
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
                                            <input type="text" value="{{ old('username') }}" class="form-control" name="username" maxlength="30" placeholder="Enter Reference Number" required/>
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
                                            <input type="text" value="{{ old('email') }}" class="form-control" name="email" maxlength="30" placeholder="Enter Reference Number" required/>
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
                                            <input type="text" value="{{ old('mobile_no') }}" class="form-control" name="mobile_no" maxlength="30" placeholder="Enter Reference Number" required/>
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
                                            <input type="text" value="{{ old('address') }}" class="form-control" name="address" maxlength="30" placeholder="Enter Reference Number" required/>
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
                                            <input type="number" value="{{ old('cod') }}" id="cod" class="form-control DropChange" name="cod" maxlength="30" placeholder="Enter COD Amount" required/>
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
                                            <input type="number" value="{{ old('shipping_amount') }}" id="shipping" class="form-control DropChange" name="shipping_amount" maxlength="30" placeholder="Enter Shipping Amount" required/>
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
                                            <input type="text" value="{{ old('total_amount') }}" id="total" class="form-control" name="total_amount" maxlength="30" placeholder="Total Amount" disabled/>
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
                                                <option selected disabled>Select</option>
                                                <option value="1">True</option>
                                                <option value="0">False</option>
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
                                                <option selected disabled>Select</option>
                                                <option value="1">True</option>
                                                <option value="0">False</option>
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
