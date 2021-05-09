@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> Edit Weight</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> Edit Weight </li>
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
                            <h3 class="panel-title">Edit Weight</h3>
                        </div>
                        <!-- Panel body -->
                        <form action="{{ route('update-weight', $id) }}" method="POST">
                            @csrf
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row"> 
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class=" control-label">Company<span style="color: red;">*</span></label>
                                            <select name="customer_id" class="form-control" disabled>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}" {{ $customer->id == $weight->customer_id ? 'selected' : '' }}>{{ $customer->full_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('customer')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label">City<span style="color: red;">*</span></label>
                                            <select name="new_city_id[]" class="form-control city" multiple>
                                                <option disabled>Select City</option>
                                                <option>All Cities</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('city_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label">Selected City<span style="color: red;">*</span></label>
                                            <select name="old_city_id[]" class="form-control city" multiple>
                                                @foreach ($weight->range as $city)
                                                    <option value="{{ $city->city->id }}" selected>{{ $city->city->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('city_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label">Range From<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $weight->range_from ?? old('rangeFrom') }}" class="form-control" name="rangeFrom" placeholder="Enter Range" required/>
                                            @error('rangeFrom')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label">Range To<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $weight->range_to ?? old('rangeTo') }}" class="form-control" name="rangeTo" placeholder="Enter Range" required/>
                                            @error('rangeTo')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label">National Amount<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $weight->national_amount ?? old('national_amount') }}" class="form-control" name="national_amount" placeholder="Enter National Amount" required/>
                                            @error('national_amount')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label">Local Amount<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $weight->local_amount ?? old('local_amount') }}" class="form-control" name="local_amount" placeholder="Enter Local Amount" required/>
                                            @error('local_amount')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div  class="col-xs-12 middlebutton">
                                        <button  type="submit" class="btn btn-info">Update</button>
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
    $(document).ready(function() {
        $('.city').select2();
    });
</script>
@endsection
