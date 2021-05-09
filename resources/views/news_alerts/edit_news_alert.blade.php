@extends('layouts.main')

@section('content')
 <div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i> Edit News Alert</h3>
        </div>
        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <!-- Panel body -->
                        <form action="{{url('/')}}/update-news-alert" method="POST"> 
                            @csrf
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label">Add News Alert<span style="color: red;">*</span></label>
                                            <input type="hidden" name="news_id" value="{{$news_alerts->id}}">
                                            <input type="text" value="{{$news_alerts->news}}" class="form-control" name="news_alert"  placeholder="Enter News Alert" required/> 
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