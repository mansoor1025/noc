@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> Add Customer</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> Add Customer </li>
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
                            <h3 class="panel-title">Add Customer</h3>
                        </div>
                        <!-- Panel body -->
                        <form action="{{ route('add-customer') }}" method="POST">
                            @csrf
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Full Name <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('name') }}" class="form-control" name="name" maxlength="30" placeholder="Enter Name" required/>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Company Name <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('company_name') }}" class="form-control" name="company_name" maxlength="30" placeholder="Enter Company Name" required/>
                                            @error('company_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Username <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('username') }}" class="form-control" name="username" maxlength="30" placeholder="Enter Username" required/>
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
									<div class="col-sm-4">
                                        <div class="form-group"> 
                                            <label class=" control-label">Password<span style="color: red;">*</span></label>
                                            <input type="password" value="{{ old('password') }}" class="form-control" name="password" maxlength="30" placeholder="Enter password" required/>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span> 
                                            @enderror
                                        </div>
                                    </div>
									<div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Confirm Password<span style="color: red;">*</span></label>
                                            <input type="password" value="{{ old('password_confirmation') }}" class="form-control" name="password_confirmation" maxlength="30" placeholder="Enter Confirm Password" required/>
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror  
                                        </div>
                                    </div> 
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Email<span style="color: red;">*</span></label>
                                            <input type="email" value="{{ old('email') }}" class="form-control" name="email" maxlength="30" placeholder="Enter Email" required/>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
									
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">1st Mobile Number<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('number1') }}" onkeypress='validate(event)' maxlength="11" class="form-control" name="number1" placeholder="Enter First Contact Number" required="" />
                                            @error('number1')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">2nd Mobile Number<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('number2') }}" onkeypress='validate(event)' maxlength="11" class="form-control" name="number2" placeholder="Enter Second Contact Number" required="" />
                                            @error('number2')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">CNIC<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('cnic') }}" onkeypress='validate(event)' maxlength="13" class="form-control" name="cnic" placeholder="Enter CNIC Number" required="" />
                                            @error('cnic')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">City <span style="color: red;">*</span></label>
											<select name="city" class="form-control">
											 <option value="">Select City</option>	
											 @foreach($city_list as $value)
											 <option value="{{$value->city_name}}">{{$value->city_name}}-{{$value->city_code}}</option>	
											 @endforeach		
											</select>	
                                            @error('city')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
									<div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Residental Address<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('residental_address') }}" class="form-control" name="residental_address" placeholder="Enter Residental Address" required/>
                                            @error('residental_address')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
									<div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label class=" control-label">Shipper Address<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('shipper_address') }}" class="form-control" name="shipper_address"  placeholder="Enter Shipper Address" required/>
                                            @error('shipper_address')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Bank <span style="color: red;">*</span></label>
                                            <select name="banks" class="form-control" required>
												<option>Select Bank Name</option> 
												@foreach($bank as $value)
												<option value="{{$value->bank_name}}">{{$value->bank_name}}</option>
												@endforeach
											</select>
                                            @error('banks')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
									<div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Account Title<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('account_title') }}" class="form-control" name="account_title" maxlength="30" placeholder="Enter Account Title" required/>
                                            @error('account_title')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
									<div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Bank Branch<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('branch') }}" class="form-control" name="branch" maxlength="30" placeholder="Enter Bank Branch" required/>
                                            @error('branch')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
									<div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Account Number<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('acc_number') }}" class="form-control" name="acc_number" maxlength="30" placeholder="Enter Bank Branch" required/>
                                            @error('acc_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Date of Birth<span style="color: red;">*</span></label>
                                            <input type="date" value="{{ old('date_of_birth') }}" class="form-control" name="date_of_birth" maxlength="30" placeholder="Enter Date of Birth" required/>
                                            @error('date_of_birth')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror 
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Anniversary Date<span style="color: red;">*</span></label>
                                            <input type="date" value="{{ old('anniversary_date') }}" class="form-control" name="anniversary_date" maxlength="30" placeholder="Enter Anniversary Date" required/>
                                            @error('anniversary_date')
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
