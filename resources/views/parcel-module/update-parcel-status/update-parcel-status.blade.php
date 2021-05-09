@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> Update Parcel Status</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> Update Parcel Status</li>
                </ol>
            </div>
        </div>
        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ route('create-parcel-status') }}"><button class="btn btn-dark" style="margin-bottom: 8px">Add Parcel Status</button></a>
                    <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Update Parcel Status With Excel</h3>
                        </div>
                        <div class="panel-body">
                            <br><br>
                            <form action="{{ route('import-parcel-status') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-6">
                                        <input type="file" name="file" class="form-control" >
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="btn btn-info">Upload Excel Sheet</button>
                                        {{-- <button class="btn btn-info">Export Excel</button> --}}
                                    </div>
                                </div>
                            </form>
                            <div class="row" style="margin-top:10px">
                                <div class="col-sm-8"></div>
                                <div class="col-sm-4">
                                    <a href="{{ route('export-parcel-status') }}">Download Sample Excel File For Format                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection