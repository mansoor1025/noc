@extends('layouts.main')

@section('content')
<div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> View Weight</h3>
            <div class="breadcrumb-wrapper">
                <span class="label">You are here:</span>
                <ol class="breadcrumb">
                    <li> <a href="/"> Home </a> </li>
                    <li class="active"> View Weight </li>
                </ol>
            </div>
        </div>
        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ route('create-weight') }}"><button class="btn btn-dark" style="margin-bottom: 8px">Add Weight</button></a>
                    <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Weight</h3>
                        </div>
                        <div class="panel-body">
                            <table id="demo-dt-basic" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Cusomer Name</th>
                                        <th>Range From</th>
                                        <th>Range To</th>
                                        <th>National Amount</th>
                                        <th>Local Amount</th>
                                        <th>City</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($weights as $key=>$value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->customer->full_name }}</td>
                                            <td>{{ $value->range_from }}</td>
                                            <td>{{ $value->range_to }}</td>
                                            <td>{{ $value->national_amount }}</td>
                                            <td>{{ $value->local_amount }}</td>
                                            <td>
                                                <select class="form-control city">
                                                    @foreach ($value->range as $city)
                                                        <option value="{{ $city->city->id }}">{{ $city->city->name }}</option>
                                                    @endforeach
                                                </select>
    
                                            </td>
                                            <td>
                                                <a href="{{route('edit-weight',encrypt($value->id))}}"><i class="fa fa-pencil"></i></a>&nbsp;|&nbsp;
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Modal -->
                            {{-- <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="title">Cities</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table" id="response_table">
                                            <thead>
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
// $(document).ready(function() {
//     $(document).on('click', "#view", function() {
//         // alert($(this).closest('.view').data("id"));
//         var data = $(this).closest('.view').data("id");

//         $.ajax({
//             url:'{{ route('view-cities') }}',
//             type:'GET',
//             async: false,
//             data: { data: data },
//             success:function(data){
//                 if(data.status == true){
//                     var tr = '';
//                     $.each(data.data, function(i, item) {
//                         tr += '<tr><td>' + (i+1) + '</td><td>' + item.city.code + '</td><td>' + item.city.name + '</td></tr>';
//                     });
//                     $('#response_table tbody').html(tr);
//                     $('#viewModal').modal('show');

//                 } else {

//                 }
//             }
//         });
//     })
// });

$(document).ready(function() {
    $('.city').select2();
});
</script>
@endsection