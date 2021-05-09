@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> Add Invoice</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> Add Invoice </li>
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
                            <h3 class="panel-title">Add Invoice</h3>
                        </div>
                        <!-- Panel body -->
                        <form action="{{ route('add-invoice') }}" method="POST">
                            @csrf
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Select Period <span style="color: red;">*</span></label>
                                            <select name="period" id="period" class="form-control">
                                                <option disabled selected>Select Period</option>
                                                @foreach ($periods as $period)
                                                    <option value="{{ $period->id }}">{{ $period->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('period')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Months <span style="color: red;">*</span></label>
                                            <select name="month" id="month" class="form-control">
                                                <option disabled selected>Select Month</option>
                                                @foreach ($months as $month)
                                                    <option value="{{ $month->id }}">{{ $month->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('month')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Year <span style="color: red;">*</span></label>
                                            <input type="number" value="{{ now()->year ?? old('year') }}" class="form-control" name="year" maxlength="30" placeholder="Enter Year" required/>
                                            @error('year')
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
                                            <label class=" control-label">Company <span style="color: red;">*</span></label>
                                            <select name="customer" class="form-control">
                                                <option selected disabled>Select Customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>
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
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Flyer Charges <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('flyer_charges') }}" class="form-control" name="flyer_charges" placeholder="Enter Flyer Charges" required/>
                                            @error('flyer_charges')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Arrear Amount <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('arrear') }}" class="form-control" name="arrear" placeholder="Enter Arrear" required/>
                                            @error('arrear')
                                                <span class="invalid-feedback" role="alert">
                                                    <p class="text-danger">{{ $message }}</p>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Deduction Amount <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ old('deduction') }}" class="form-control" name="deduction" placeholder="Enter Deduction Amount" required/>
                                            @error('deduction')
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
