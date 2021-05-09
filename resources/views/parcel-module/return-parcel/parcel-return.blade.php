@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> View Parcel Return</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> View Parcel Return </li>
                </ol>
            </div>
        </div>
        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <form style="display: flex" action="{{ route('parcel-return') }}" method="POST">
                                @csrf
                                <input name="tracking_no" placeholder="Enter Tracking Number" style="border-radius: 100px; background-color:#efefef" type="text" class="form-control">
                                <button type="submit" style="margin-left: 8px;" class="btn btn-dark">Return</button>
                            </form>
                        </div>
                    </div>
                        <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Parcel Return</h3>
                        </div>
                        <div class="panel-body">
                            <table id="demo-dt-basic" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Parcel Status</th>
                                        <th>Tracking ID</th>
                                        <th>Reference No</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($return_parcels as $key=>$value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>Return</td>
                                            <td>{{ $value->tracking_id }}</td>
                                            <td>{{ $value->reference_no }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection