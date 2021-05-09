@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> View Parcel Status</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> View Parcel Status </li>
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
                            <h3 class="panel-title">Parcel Status</h3>
                        </div>
                        <div class="panel-body">
                            <table id="demo-dt-basic" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Parcel Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($parcels as $key=>$value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->parcel_status }}</td>
                                            <td>
                                                <a href="{{route('edit-parcel-status',encrypt($value->id))}}"><i class="fa fa-pencil"></i></a>&nbsp;|&nbsp;
                                            </td>
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