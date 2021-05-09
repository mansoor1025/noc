@extends('layouts.main')

@section('content')
<?php
	$show_password = DB::table('users')->where('id',$customer->user_id)->value('show_password');
?>
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> View Cuatomer</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> View Cuatomer </li>
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
                            <h3 class="panel-title">View Cuatomer</h3>
                        </div>
                        <!-- Panel body -->
                        <form>
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Full Name <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $customer->full_name ?? old('name') }}" class="form-control" name="name" maxlength="30" placeholder="Enter Name" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Company Name <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $customer->company_name ?? old('company_name') }}" class="form-control" name="company_name" maxlength="30" placeholder="Enter Company Name" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Username <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $customer->user_name ?? old('username') }}" class="form-control" name="username" maxlength="30" placeholder="Enter Username" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Email<span style="color: red;">*</span></label>
                                            <input type="email" value="{{ $customer->email ?? old('email') }}" class="form-control" name="email" maxlength="30" placeholder="Enter Email" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">1st Mobile Number<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $customer->mobile_no_1 ?? old('number1') }}" onkeypress='validate(event)' maxlength="11" class="form-control" name="number1" placeholder="Enter First Contact Number" disabled="" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">2nd Mobile Number<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $customer->mobile_no_2 ?? old('number2') }}" onkeypress='validate(event)' maxlength="11" class="form-control" name="number2" placeholder="Enter Second Contact Number" disabled="" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">CNIC<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $customer->cnic ?? old('cnic') }}" onkeypress='validate(event)' maxlength="13" class="form-control" name="cnic" placeholder="Enter CNIC Number" disabled="" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">City <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $customer->city ?? old('city') }}" class="form-control" name="city" maxlength="30" placeholder="Enter City" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Bank <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $customer->bank ?? old('bank') }}" class="form-control" name="bank" maxlength="30" placeholder="Enter Bank" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Bank Branch<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $customer->bank_branch ?? old('branch') }}" class="form-control" name="branch" maxlength="30" placeholder="Enter Bank Branch" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Account Title<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $customer->account_title ?? old('account_title') }}" class="form-control" name="account_title" maxlength="30" placeholder="Enter Account Title" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Date of Birth<span style="color: red;">*</span></label>
                                            <input type="date" value="{{ $customer->birth_date ?? old('date_of_birth') }}" class="form-control" name="date_of_birth" maxlength="30" placeholder="Enter Date of Birth" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">Anniversary Date<span style="color: red;">*</span></label>
                                            <input type="date" value="{{ $customer->anniversary_date ?? old('anniversary_date') }}" class="form-control" name="anniversary_date" maxlength="30" placeholder="Enter Anniversary Date" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label">Address<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $customer->shipper_address ?? old('address') }}" class="form-control" name="address" maxlength="30" placeholder="Enter Address" disabled/>
                                        </div>
                                    </div>
									@if(Auth::user()->role_id == 1)
									<div class="col-sm-3">
                                        <div class="form-group">
                                            <label class=" control-label">Show Password<span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $show_password }}" class="form-control"  disabled/>
                                        </div> 
                                    </div>
									@endif
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
