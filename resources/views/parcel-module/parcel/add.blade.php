@extends('layouts.main')

@section('content')
<?php
  $default_cities = ['KARACHI','LAHORE','ISLAMABAD','PESHAWAR','QUETTA'];

 ?>
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
                                    
                                    <!--<div class="col-sm-4">
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
                                    </div>-->
                                    <input type="number" name="status_id" value="7" style="display:none;">
									@if(Auth::user()->role_id ==  1)
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Shipping Partner <span style="color: red;">*</span></label>
                                            <select class="form-control" name="shipping_ids" id="shipping_id" disabled>
												<option value="">Select Shipping Partner</option>
                                                @foreach ($partners as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
											<input type="hidden" name="shipping_id" id="user_shipping_id" value="" >
                                            @error('shipping_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
									@else
										<input type="hidden" name="shipping_id" id="user_shipping_id" value="" >	
									@endif

                                    <div class="col-sm-4">
                                        <div class="form-group" @if(count($customers)==1)style="display:none"@endif >
                                            <label class=" control-label">Company <span style="color: red;">*</span></label>
                                            <select class="form-control" name="customer_id">
                                                @if(count($customers)>1)
                                                    <option selected disabled>Select Customer</option>
                                                @endif
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
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Weight <span style="color: red;">*</span></label>
                                            <input type="number" min="0.01" step="0.01" value="{{ old('weight') }}" class="form-control" name="weight" id="weight" maxlength="30" placeholder="Enter Weight" required/>
                                            @error('weight')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
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
                                            <label class=" control-label">Consignee Name <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('username') }}" class="form-control" name="username" maxlength="30" placeholder="Enter Consignee Name" required/>
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Consignee Email <span style="color: red;"></span></label>
                                            <input type="text" value="{{ old('email') }}" class="form-control" name="email" maxlength="30" placeholder="Enter Consginee Email" />
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
                                            <input type="number" min="0"  maxlength="11" value="{{ old('mobile_no') }}" class="form-control" name="mobile_no" maxlength="30" placeholder="Enter Consignee Number" required/>
                                            @error('mobile_no')
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
                                            <label class=" control-label">Consignee Address <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('address') }}" class="form-control" name="address" placeholder="Enter Consignee Address" required/>
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
									<div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label">Product Detail<span style="color: red;">*</span></label> 
                                            <input type="text" value="{{ old('product_Detail') }}" class="form-control" name="product_Detail" placeholder="Enter Product Detail" required/>
                                            @error('product_Detail')
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
                                            <input type="number" min="0" max="100000" value="{{ old('cod') }}" id="cod" class="form-control DropChange" name="cod" maxlength="30" placeholder="Enter COD Amount" required/>
                                            @error('cod')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Select Province <span style="color: red;">*</span></label>
                                            <select class="form-control" name="province_id">
                                                <option selected disabled>Select</option>
                                                @foreach ($provinces as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('province_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Destination City <span style="color: red;">*</span></label>
                                            <select class="form-control" name="city_id" onchange="filter_shipping_id(this.value,{{Auth::user()->role_id}})">
                                                <option selected disabled>Select</option>
												  <?php
													foreach($cities_name['allCities'] as $key => $value){
														
															?><option value="<?php echo $value['cityCode'] ?>"><?php echo $value['cityName']  .'-'. $value['cityCode']?></option><?php
															
														}
														?>
												 
                                            </select>
                                            @error('city_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-4">
                                        <div class="form-group"> 
                                            <label class=" control-label">Shipping Amount <span style="color: red;">*</span></label>
                                            <input type="number" min="0" value="{{ old('shipping_amount') }}" id="shipping" class="form-control DropChange" name="shipping_amount" maxlength="30" placeholder="Enter Shipping Amount" required/>
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
                                            <input type="number" min="0" value="{{ old('total_amount') }}" id="total" class="form-control" name="total_amount" maxlength="30" placeholder="Total Amount" disabled/>
                                            @error('total_amount')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> --}}
                                </div>
                                {{-- <div class="row">
                                    
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
                                </div> --}}
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
<script>
 function filter_shipping_id(value,role_id){
	var weight = $("#weight").val();
	if(weight > 1){
		 $("#shipping_id").val(1);
		 $("#user_shipping_id").val(1);
	}
	else if(value == 'KHI' || value == 'HDD' || value == 'LHE'){
	     $("#shipping_id").val(1);
		 $("#user_shipping_id").val(1);
	 }
	else{
	    $("#shipping_id").val(2);
	    $("#user_shipping_id").val(2);
	 }
 }
  </script>
@endsection
