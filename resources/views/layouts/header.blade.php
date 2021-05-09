<!--NAVBAR-->
<!--===================================================-->
<?php
 $customer_notification = DB::table('customers')->where([['status',2],['new_notification_status',0]]);
 $current_date = date("Y-m-d");
 $current_dates = date("Y-m-d", strtotime($current_date));
 $count_total_notifications = 0;
 $customer_dob = DB::table('customers')->where([['status',2],['user_id',Auth::user()->id],['birth_date',$current_dates]]); 
 $customer_ann = DB::table('customers')->where([['status',2],['user_id',Auth::user()->id],['anniversary_date',$current_dates]]);
 $load_sheet_notify = DB::table('load_sheets')->where('notification_status',0);
 
 if(Auth::user()->role_id == 3){
	 $count_total_notifications = $customer_dob->count() + $customer_ann->count();
 }
else{
	$count_total_notifications = $customer_dob->count() + $customer_ann->count() + $customer_notification ->count() + $load_sheet_notify->count();
} 
?>
<header id="navbar">
    <div id="navbar-container" class="boxed">
        <!--Navbar Dropdown-->
        <!--================================-->
        <div class="navbar-content clearfix">
            <ul class="nav navbar-top-links pull-left">
                
                <li class="tgl-menu-btn"> 
                    <a class="mainnav-toggle" href="#"> <i class="fa fa-navicon fa-lg"></i> </a>
                </li>
                
                {{-- <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle"> <i class="fa fa-envelope fa-lg"></i> <span class="badge badge-header badge-warning">9</span> 
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-md with-arrow">
                        <div class="pad-all bord-btm">
                            <div class="h4 text-muted text-thin mar-no">You have 3 messages.</div>
                        </div>
                        <div class="nano scrollable">
                            <div class="nano-content">
                                <ul class="head-list">
                                    <li>
                                        <a href="#" class="media">
                                            <div class="media-left"> <img src="assets/img/av2.png" alt="Profile Picture" class="img-circle img-sm"> </div>
                                            <div class="media-body">
                                                <div class="text-nowrap">Andy sent you a message</div>
                                                <small class="text-muted">15 minutes ago</small> 
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--Dropdown footer-->
                        <div class="pad-all bord-top">
                            <a href="#" class="btn-link text-dark box-block"> <i class="fa fa-angle-right fa-lg pull-right"></i>Show All Messages </a>
                        </div>
                    </div>
                </li> --}}
                <li class="dropdown" id="notification_button">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle"> <i class="fa fa-bell fa-lg"></i> 
					@if($count_total_notifications > 0)
                        <span class="badge badge-header badge-danger">{{$count_total_notifications}}</span> 
                    @else
                        <span class="badge badge-header badge-danger">0</span> 
                    @endif
                    </a>
                    <!--Notification dropdown menu-->
                    <div class="dropdown-menu dropdown-menu-md with-arrow" style="min-width: 300px;">
                        <div class="pad-all bord-btm">
                            <div class="h4 text-muted text-thin mar-no"> Notification </div>
                        </div>
                        <div class="nano scrollable">
                            <div class="nano-content">
                                <ul class="head-list">
                                    <!-- Dropdown list-->
                                    <li>
									   @if(Auth::user()->role_id == 1)
                                          @if($customer_notification->count() > 0 )
                                            <a href="#" class="media">
                                                <span class="label label-danger pull-right">New</span>
                                                <div class="media-left"> <span class="icon-wrap icon-circle bg-purple"> <i class="fa fa-comment fa-lg"></i> </span> </div>
                                                <div class="media-body">
                                                    <div class="text-nowrap">New Customer</div>
                                                    @foreach($customer_notification->get() as $value)
                                                    <small class="text-muted">   
                                                      {{ $value->full_name }}<br>
                                                     </small> 
                                                   @endforeach
                                                </div> 
                                            </a>
											@endif
											@if($load_sheet_notify->count() > 0)  
											  
												<a href="#" class="media">
													<span class="label label-danger pull-right">New</span>
													<div class="media-left"> <span class="icon-wrap icon-circle bg-purple"> <i class="fa fa-comment fa-lg"></i> </span> </div>
													<div class="media-body">
														<div class="text-nowrap">{{$load_sheet_notify->count()}} New Load sheet</div>
													</div>
												</a>
									        
										@endif	 
										@endif	
										@if($customer_dob->count() > 0 )
											 
												<a href="#" class="media">
													<span class="label label-danger pull-right">New</span>
													<div class="media-left"> <span class="icon-wrap icon-circle bg-purple"> <i class="fa fa-comment fa-lg"></i> </span> </div>
													<div class="media-body">
														<div class="text-nowrap">Birthday Alert</div>
														@foreach($customer_dob->get() as $value)
														<small class="text-muted">   
														  Happy Bithday {{Auth::user()->full_name}}<br>
														 </small> 
													   @endforeach
													</div>
												</a>
										 @endif	 
									    @if($customer_ann->count() > 0 )
											
												<a href="#" class="media">
													<span class="label label-danger pull-right">New</span>
													<div class="media-left"> <span class="icon-wrap icon-circle bg-purple"> <i class="fa fa-comment fa-lg"></i> </span> </div>
													<div class="media-body">
														<div class="text-nowrap">Marriage Anniversy Alert</div>
														@foreach($customer_ann->get() as $value)
														<small class="text-muted">   
														  Happy Anniversy {{Auth::user()->full_name}}<br>
														 </small> 
													   @endforeach
													</div>
												</a>
									        
										@endif	 	 
											 
                                        @if($customer_notification->count() == 0 && $customer_dob->count() == 0 && $customer_ann->count() == 0 && $load_sheet_notify->count() == 0)
                                            <a href="#" class="media">
                                                <div class="media-body">
                                                    <div class="text-nowrap">No Notification</div>
                                                </div>
                                            </a>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--Dropdown footer-->
                        {{-- <div class="pad-all bord-top">
                            <a href="#" class="btn-link text-dark box-block"> <i class="fa fa-angle-right fa-lg pull-right"></i>Show All Notifications </a>
                        </div> --}}
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End notifications dropdown-->
            </ul>
            <ul class="nav navbar-top-links pull-right">
                <!--Profile toogle button-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="hidden-xs" id="toggleFullscreen">
                    <a class="fa fa-expand" data-toggle="fullscreen" href="#" role="button">
                    <span class="sr-only">Toggle fullscreen</span>
                    </a>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End Profile toogle button-->
                <!--User dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li id="dropdown-user" class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                        <span class="pull-right"> <img class="img-circle img-user media-object" src="assets/img/av1.png" alt="Profile Picture"> </span>
                        <div class="username hidden-xs">{{ Auth::user()->full_name ?? '' }}</div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right with-arrow">
                        <!-- User dropdown menu -->
                        <ul class="head-list">
                            <li>
                                <a href="{{ url('checkout') }}"> <i class="fa fa-sign-out fa-fw"></i>Checkout </a>
                            </li>
                            <li>
                                <a href="{{ url('logout') }}"> <i class="fa fa-sign-out fa-fw"></i> Logout </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End user dropdown-->
            </ul>
        </div>
        <!--================================-->
        <!--End Navbar Dropdown-->
    </div>
</header>
<script type="text/javascript">
    $("#notification_button").click(function(e){ 
        e.preventDefault();
        var url = '{{url("/")}}/update_notification';
        $.ajax({
            type:'GET',
            url:url,
            data:{},
            success:function(res){
                //alert(res);
            }
        });
    });
</script>
<!--===================================================-->
<!--END NAVBAR-->