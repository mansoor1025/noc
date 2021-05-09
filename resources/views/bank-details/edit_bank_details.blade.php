@extends('layouts.main')

@section('content')
 <div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> Edit Bank Details</h3>
        </div>
        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <!-- Panel body -->
                        <form action="{{url('/')}}/update-bank-details" method="POST"> 
                            @csrf
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label">Add Branch Code<span style="color: red;">*</span></label>
                                            <input type="hidden" name="bank_id" value="{{$edit_bank_detail->id}}">
                                            <input type="text" value="{{$edit_bank_detail->branch_code}}" class="form-control" name="branch_code" maxlength="30" placeholder="Enter Branch Code" required/> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label">Add Bank Name<span style="color: red;">*</span></label>
                                            <input type="text" value="{{$edit_bank_detail->bank_name}}" class="form-control" name="bank_name" maxlength="30" placeholder="Enter Bank Name" required/>
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