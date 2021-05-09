@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> View Employee</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> View Employee </li>
                </ol>
            </div>
        </div>
        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ route('create-employee') }}"><button class="btn btn-dark btn-lg" style="margin-bottom: 8px">Add Employee</button></a>
                    <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Employee</h3>
                        </div>
                        <div class="panel-body">
                            <table id="demo-dt-basic" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Role</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($employees as $key=>$value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->full_name }}</td>
                                            <td>{{ $value->role->role }}</td>
                                            <td>{{ $value->mobile_number }}</td>
                                            <td>{{ $value->email }}</td>
                                            <td>
                                                {{-- <a href="{{route('view-employee',encrypt($value->id))}}"><i class="fa fa-eye"></i></a>&nbsp;|&nbsp; --}}
                                                <a href="{{route('edit-employee',encrypt($value->id))}}"><i class="fa fa-pencil"></i></a>&nbsp;|&nbsp;
                                                {{-- <a href="{{route('delete-employee',encrypt($value->id))}}"><i class="fa fa-trash delete"></i></a> --}}
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