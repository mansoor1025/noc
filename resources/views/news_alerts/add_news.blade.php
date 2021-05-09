@extends('layouts.main')

@section('content')
 <div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> Add News Alert</h3>
        </div> 
        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <!-- Panel body -->
                        <form action="{{url('/')}}/add-news-alerts" method="POST">
                            @csrf
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <div class="form-group">
                                            <label class=" control-label">Add News<span style="color: red;">*</span></label>
                                            <input type="text" value="" class="form-control" name="add_news"  placeholder="Enter Add News" required/>
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
                                                     <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-body">
                            <table id="demo-dt-basic" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>News Details</th>
                                        <th>status</th>
                                        <th>Created On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php $counter = 1; ?>
                                     @foreach($news_alert as $value)
                                      <tr>
                                        <td>{{$counter++}}</td>
                                        <td>{{$value->news}}</td>
                                        <td>
                                            <select name="active_status" class="form-control" onchange="change_status(this.value,<?php echo $value->id ?>)">
                                                <option value="1" @if($value->status == 1)selected @endif>active</option>
                                                <option value="0" @if($value->status == 0)selected  @endif>unactive</option>
                                            </select>
                                        </td>
                                        <td>
                                            {{$value->created_on}}
                                        </td>
                                        <td>
                                            <a href="{{route('view-news-details',encrypt($value->id))}}"><i class="fa fa-eye"></i></a>&nbsp;|&nbsp;
                                            <a href="{{route('edit-news-alert',encrypt($value->id))}}"><i class="fa fa-pencil"></i></a>&nbsp;|&nbsp;
                                        </td>
                                      </tr>
                                     @endforeach
                                </tbody>
                             
                            </table>
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
<script type="text/javascript">
    function change_status(value,id){
        $.ajax({
            type:'GET',
            url:'<?php echo url('/') ?>/change_status',
            data:{value:value,id:id},
            success:function(res){
             //   alert(res);
            }
        });
    }
</script>              
@endsection