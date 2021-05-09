@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> Add Weight</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> Add Weight </li>
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
                            <h3 class="panel-title">Add Weight</h3>
                        </div>
                        <!-- Panel body -->
                        <form action="{{ route('add-weight') }}" method="POST">
                            @csrf
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row"> 
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label">Company<span style="color: red;">*</span></label>
                                            <select name="customer_id" class="form-control">
                                                <option selected disabled>Select Vendor</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('customer_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label">City<span style="color: red;">*</span></label>
                                            <select name="city_id[]" class="form-control city" multiple>
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
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">Range From<span style="color: red;">*</span></label>
                                            <input type="text" value="0.01" class="form-control" name="rangeFrom[]" readonly/>
                                            @error('rangeFrom.0')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">Range To<span style="color: red;">*</span></label>
                                            <input type="text" value="0.5" class="form-control" name="rangeTo[]" readonly/>
                                            @error('rangeTo.0')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">National Amount<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('national_amount.0') }}" class="form-control" name="national_amount[]" placeholder="Enter National Amount" required/>
                                            @error('national_amount.0')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">Local Amount<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('local_amount.0') }}" class="form-control" name="local_amount[]" placeholder="Enter Local Amount" required/>
                                            @error('local_amount.0')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">Range From<span style="color: red;">*</span></label>
                                            <input type="text" value="0.501" class="form-control" name="rangeFrom[]" readonly/>
                                            @error('rangeFrom.1')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">Range To<span style="color: red;">*</span></label>
                                            <input type="text" value="1" class="form-control" name="rangeTo[]" readonly/>
                                            @error('rangeTo.1')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">National Amount<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('national_amount.1') }}" class="form-control" name="national_amount[]" placeholder="Enter National Amount" required/>
                                            @error('national_amount.1')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">Local Amount<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('local_amount.1') }}" class="form-control" name="local_amount[]" placeholder="Enter Local Amount" required/>
                                            @error('local_amount.1')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">Range From<span style="color: red;">*</span></label>
                                            <input type="text" value="1.1" class="form-control" name="rangeFrom[]" readonly/>
                                            @error('rangeFrom.2')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">Range To<span style="color: red;">*</span></label>
                                            <input type="text" value="3" class="form-control" name="rangeTo[]" readonly/>
                                            @error('rangeTo.2')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">National Amount<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('national_amount.2') }}" class="form-control" name="national_amount[]" placeholder="Enter National Amount" required/>
                                            @error('national_amount.2')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">Local Amount<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('local_amount.2') }}" class="form-control" name="local_amount[]" placeholder="Enter Local Amount" required/>
                                            @error('local_amount.2')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">Range From<span style="color: red;">*</span></label>
                                            <input type="text" value="3.1" class="form-control" name="rangeFrom[]" readonly/>
                                            @error('rangeFrom.3')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">Range To<span style="color: red;">* 3.1+</span></label>
                                            <input type="text" value="3.1" class="form-control" name="rangeTo[]" readonly/>
                                            @error('rangeTo.3')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">National Amount<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('national_amount.3') }}" class="form-control" name="national_amount[]" placeholder="Enter National Amount" required/>
                                            @error('national_amount.3')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">Local Amount<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('local_amount.3') }}" class="form-control" name="local_amount[]" placeholder="Enter Local Amount" required/>
                                            @error('local_amount.3')
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
<script type="text/javascript">
    $(document).ready(function() {
        $('.city').select2();
    });
</script>    
@endsection