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
                    <div class="panel">
                        <!-- Panel heading -->
                        <div class="panel-heading">
                            <h3 class="panel-title">View Parcel</h3>
                        </div>
                        <!-- Panel body -->
                        <form>
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Company</label>
                                            <select class="form-control" name="customer_id" disabled>
                                                @foreach ($customers as $value)
                                                    <option value="{{ $value->id }}" {{ $parcel->customer_id == $value->id ? 'selected' : '' }}>{{ $value->full_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Parcel Status</label>
                                            <select class="form-control" name="status_id" disabled>
                                                @foreach ($statuses as $value)
                                                    <option value="{{ $value->id }}" {{ $parcel->parcel_status_id == $value->id ? 'selected' : '' }}>{{ $value->parcel_status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Shipping Partner</label>
                                            <select class="form-control" name="shipping_id" disabled>
                                                @foreach ($partners as $value)
                                                    <option value="{{ $value->id }}" {{ $parcel->shipping_partner_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Weight</label>
                                            <input type="text" value="{{ $parcel->weight ?? old('weight') }}" class="form-control" name="weight" maxlength="30" placeholder="Enter Weight" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label class=" control-label">Reference No</label>
                                            <input type="text" value="{{ $parcel->reference_no ?? old('reference_no') }}" class="form-control" name="reference_no" maxlength="30" placeholder="Enter Reference Number" disabled/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Username</label>
                                            <input type="text" value="{{ $parcel->user_name ?? old('username') }}" class="form-control" name="username" maxlength="30" placeholder="Enter Reference Number" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Email</label>
                                            <input type="text" value="{{ $parcel->email ?? old('email') }}" class="form-control" name="email" maxlength="30" placeholder="Enter Reference Number" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Mobile Number</label>
                                            <input type="text" value="{{ $parcel->mobile_no ?? old('mobile_no') }}" class="form-control" name="mobile_no" maxlength="30" placeholder="Enter Reference Number" disabled/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class=" control-label">User Address</label>
                                            <input type="text" value="{{ $parcel->user_address ?? old('address') }}" class="form-control" name="address" maxlength="30" placeholder="Enter Reference Number" disabled/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">COD Amount</label>
                                            <input type="number" value="{{ $parcel->cod_amount ?? old('cod') }}" id="cod" class="form-control DropChange" name="cod" maxlength="30" placeholder="Enter COD Amount" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Shipping Amount</label>
                                            <input type="number" value="{{ $parcel->shipping_amount ??  old('shipping_amount') }}" id="shipping" class="form-control DropChange" name="shipping_amount" maxlength="30" placeholder="Enter Shipping Amount" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Total Amount</label>
                                            <input type="text" value="{{ $parcel->total_amount ?? old('total_amount') }}" id="total" class="form-control" name="total_amount" maxlength="30" placeholder="Total Amount" disabled/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Province</label>
                                            <select class="form-control" name="rider" disabled>
                                                @foreach ($provinces as $value)
                                                    <option>{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Destination City</label>
                                            <select class="form-control" name="rider" disabled>
                                                @foreach ($cities as $value)
                                                    <option>{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Rider Print</label>
                                            <select class="form-control" name="rider" disabled>
                                                @if($parcel->rider_print == 1)
                                                    <option value="1" selected>True</option>
                                                    <option value="0">False</option>
                                                @else
                                                    <option value="1">True</option>
                                                    <option value="0" selected>False</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Validate</label>
                                            <select class="form-control" name="validate" disabled>
                                                @if($parcel->validate == 1)
                                                    <option value="1" selected>True</option>
                                                    <option value="0">False</option>
                                                @else
                                                    <option value="1">True</option>
                                                    <option value="0" selected>False</option>
                                                @endif
                                            </select>
                                        </div>
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