@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> View Bank Details</h3>
        </div>
        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <form>
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label">Branch Code <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $view_bank_detail->branch_code }}" class="form-control" name="name" maxlength="30" placeholder="Enter Name" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label">Branch Name <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $view_bank_detail->bank_name }}" class="form-control" name="company_name" maxlength="30" placeholder="Enter Company Name" disabled/>
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
