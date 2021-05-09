@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> Edit Cuatomer</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> Edit Cuatomer </li>
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
                            <h3 class="panel-title">Edit Cuatomer</h3>
                        </div>
                        <!-- Panel body -->
                        <form action="{{ route('update-customer', $id) }}" method="POST">
                            @csrf
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Full Name <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $customer->full_name ?? old('name') }}" class="form-control" name="name" maxlength="30" placeholder="Enter Name" required/>
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
                                            <input type="text" value="{{ $customer->company_name ?? old('company_name') }}" class="form-control" name="company_name" maxlength="30" placeholder="Enter Company Name" required/>
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
                                            <input type="text" value="{{ $customer->user_name ?? old('username') }}" class="form-control" name="username" maxlength="30" placeholder="Enter Username" required/>
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Email<span style="color: red;">*</span></label>
                                            <input type="email" value="{{ $customer->email ?? old('email') }}" class="form-control" name="email" maxlength="30" placeholder="Enter Email" required/>
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
                                            <input type="text" value="{{ $customer->mobile_no_1 ?? old('number1') }}" onkeypress='validate(event)' maxlength="11" class="form-control" name="number1" placeholder="Enter First Contact Number" required="" />
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
                                            <input type="text" value="{{ $customer->mobile_no_2 ?? old('number2') }}" onkeypress='validate(event)' maxlength="11" class="form-control" name="number2" placeholder="Enter Second Contact Number" required="" />
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
                                            <input type="text" value="{{ $customer->cnic ?? old('cnic') }}" onkeypress='validate(event)' maxlength="13" class="form-control" name="cnic" placeholder="Enter CNIC Number" required="" />
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
                                            <input type="text" value="{{ $customer->city ?? old('city') }}" class="form-control" name="city" maxlength="30" placeholder="Enter City" required/>
                                            @error('city')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Bank <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $customer->bank ?? old('bank') }}" class="form-control" name="bank" maxlength="30" placeholder="Enter Bank" required/>
                                            @error('bank')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Bank Branch<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $customer->bank_branch ?? old('branch') }}" class="form-control" name="branch" maxlength="30" placeholder="Enter Bank Branch" required/>
                                            @error('branch')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Account Title<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $customer->account_title ?? old('account_title') }}" class="form-control" name="account_title" maxlength="30" placeholder="Enter Account Title" required/>
                                            @error('account_title')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Date of Birth<span style="color: red;">*</span></label>
                                            <input type="date" value="{{ $customer->birth_date ?? old('date_of_birth') }}" class="form-control" name="date_of_birth" maxlength="30" placeholder="Enter Date of Birth" required/>
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
                                            <input type="date" value="{{ $customer->anniversary_date ?? old('anniversary_date') }}" class="form-control" name="anniversary_date" maxlength="30" placeholder="Enter Anniversary Date" required/>
                                            @error('anniversary_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label class=" control-label">Address<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $customer->shipper_address ?? old('address') }}" class="form-control" name="address" maxlength="30" placeholder="Enter Address" required/>
                                            @error('address')
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
