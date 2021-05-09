@extends('layouts.main')

@section('content')
<?php
use App\User;
$users_data = user::where('change_password_status',1)->get();
 ?>
 <div class="boxed">
    <div id="content-container">
        <div class="pageheader hidden-xs">
            <h3><i class="fa fa-home"></i>User Change Password</h3>
        </div> 
        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <!-- Panel body -->
                        <form action="{{url('/')}}/user-change-password" method="POST">
                            @csrf
                            <div style="margin-left:50px;" class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class=" control-label">Select users<span style="color: red;">*</span></label>
                                            <select name="user_name" id="user_name" class="form-control">
                                              <option value="">Select users</option>	
                                            	@foreach($users as $value)
                                            	  <option value="{{$value->user_id}}">
                                            	  	{{$value->company_name}}
                                            	  </option>

                                            	@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label class=" control-label">Change Password<span style="color: red;">*</span></label> 
                                            <input type="password" value="" class="form-control" name="password" maxlength="30" placeholder="Enter Change Password" required/>
                                        </div>
                                    </div>
									<div class="col-sm-4">
                                        <div class="form-group"> 
                                            <label class=" control-label">Confirm Password<span style="color: red;">*</span></label>
                                            <input type="password" value="" class="form-control" name="password_confirmation" maxlength="30" placeholder="Enter Confirm Password" required/>
											<p>@if($errors->any()){{session('errors')->first('error')}}@endif</p>
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
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Updated On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	 <?php $counter = 1; ?>
                                	 @foreach($users_data as $value)
                                	  <tr>
                                	  	<td>{{$counter++}}</td>
                                	  	<td>{{$value->full_name}}</td>
										
										<td>	
											@if($value->show_password != '')
											 {{$value->show_password}}
											@else
												**********
											@endif
										</td>
                                	  	<td>{{date('d-m-Y', strtotime($value->updated_at))}}</td> 
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
@endsection