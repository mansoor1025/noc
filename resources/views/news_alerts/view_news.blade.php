@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> View News Alert</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> View News Alert </li>
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
                            <h3 class="panel-title"></h3>
                        </div>
                        <!-- Panel body -->
                        <form>
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <div class="form-group">
                                            <label class=" control-label">News Alert <span style="color: red;">*</span></label>
                                            <input type="text" value="{{ $news_alerts->news ?? old('name') }}" class="form-control" name="news_alert" placeholder="Enter News Alert" disabled/>
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
