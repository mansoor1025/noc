<?php
 $customer_notification = DB::table('customers')->where([['status',2],['new_notification_status',0]]); 
 $load_sheet_notification = DB::table('load_sheets')->where('notification_status',0); 
?>
<nav id="mainnav-container">
    <!--Brand logo & name-->
    <!--================================-->
    <div class="navbar-header">
        <a href="/" class="navbar-brand">
            <i class="fa fa-forumbee brand-icon"></i>
            <div class="brand-title">
                <span class="brand-text">NOC</span>
            </div>
        </a>
    </div>
    <!--================================-->
    <!--End brand logo & name-->
    <div  id="mainnav">
        <div  id="mainnav-menu-wrap">
            <div style="display:inline-block;" class="nano">
                <div  class="nano-content">
                    <ul id="mainnav-menu" class="list-group sidebar-menu">
                        <!--Category name-->
                        <li class="list-header">Navigation</li>
                        <!--Menu list item-->
                        <li> <a href="{{ route('dashboard') }}"> <i class="fa fa-home"></i> <span class="menu-title"> <b>Dashboard</b> </span> </a> </li>
                        <!--Menu list item-->
                        @if(Auth::user()['id'] == 1)
                            <li>
                                <a href="#">
                                <i class="fa fa-th"></i>
                                <span class="menu-title">
                                    <b>HR Module</b>
                                </span>
                                <i class="arrow"></i>
                                </a>
                                <!--Submenu-->
                                <ul class="collapse">
                                    <li><a href="{{ route('employees') }}"><i class="fa fa-caret-right"></i>Employees</a></li>
                                     <li id="notification_button">
                                        <a href="{{ route('customers') }}"><i class="fa fa-caret-right"></i>Customers
                                            @if($customer_notification->count() > 0)
                                            <span class="badge badge-danger"> {{$customer_notification->count()}}</span>   
                                            @endif

                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                <i class="fa fa-th"></i>
                                <span class="menu-title">
                                    <b>Shipping</b>
                                </span>
                                <i class="arrow"></i>
                                </a>
                                <!--Submenu-->
                                <ul class="collapse">
                                    <li><a href="{{ route('shipping-partners') }}"><i class="fa fa-caret-right"></i>Shipping</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                <i class="fa fa-th"></i>
                                <span class="menu-title">
                                    <b>Invoice</b>
                                </span>
                                <i class="arrow"></i>
                                </a>
                                <!--Submenu-->
                                <ul class="collapse">
                                    <li><a href="{{ route('invoices') }}"><i class="fa fa-caret-right"></i>Invoice</a></li>
                                </ul>
                            </li>
                        @endif

                        <li>
                            <a href="#">
                            <i class="fa fa-th"></i>
                            <span class="menu-title">
                                <b>Parcel</b>
                            </span>
                            <i class="arrow"></i>
                            </a>
                            <!--Submenu-->
                            <ul class="collapse">
                                <li><a href="{{ route('parcels') }}"><i class="fa fa-caret-right"></i>Parcels</a></li>
                                @if(Auth::user()['id'] != 1)
                                    <li><a href="{{ route('load-sheet') }}"><i class="fa fa-caret-right"></i>Load Sheet</a></li>
									<li><a href="{{ route('load-sheet-summary') }}"><i class="fa fa-caret-right"></i>Load Sheet Summary</a></li>
                                @endif
                                @if(Auth::user()['id'] == 1)
                                    <li><a href="{{ route('parcel-statuses') }}"><i class="fa fa-caret-right"></i>Parcel Statuses</a></li>
                                    <li>
										<a href="{{ route('validate-parcel') }}"><i class="fa fa-caret-right"></i>Validate Parcel
											@if($load_sheet_notification->count() > 0)
												<span class="badge badge-danger"> {{$load_sheet_notification->count()}}</span>   
											@endif
										</a>
									</li>
									<li><a href="{{ route('weight-correction') }}"><i class="fa fa-caret-right"></i>Weight Correction</a></li>
                                    <li><a href="{{ route('update-parcel-status-via-tcs-no') }}"><i class="fa fa-caret-right"></i>Update Status</a></li>
                                    <li><a href="{{ route('return-parcels') }}"><i class="fa fa-caret-right"></i>Return Parcel</a></li>
									<li><a href="{{ route('tcs-tracking') }}"><i class="fa fa-caret-right"></i>Tcs Tracking</a></li>
                                @endif
                            </ul>
                        </li>

                        @if(Auth::user()['id'] == 1)
                            <li>
                                <a href="#">
                                <i class="fa fa-th"></i>
                                <span class="menu-title">
                                    <b>Payment</b>
                                </span>
                                <i class="arrow"></i>
                                </a>
                                <!--Submenu-->
                                <ul class="collapse">
                                    <li><a href="{{ route('payment-methods') }}"><i class="fa fa-caret-right"></i>Payment Method</a></li>
                                </ul>
                            </li>
                        @endif

                        @if(Auth::user()['id'] == 1)
                        <li>
                            <a href="#">
                            <i class="fa fa-th"></i>
                            <span class="menu-title">
                                <b>Miscellaneous</b>
                            </span>
                            <i class="arrow"></i>
                            </a>
                            <!--Submenu-->
                            <ul class="collapse">
                                <li><a href="{{ route('cities') }}"><i class="fa fa-caret-right"></i>City</a></li>
                                <li><a href="{{ route('weights') }}"><i class="fa fa-caret-right"></i>Weight Range </a></li>
                                <li><a href="{{ route('customer-wallet') }}"><i class="fa fa-caret-right"></i>Customer Wallet </a></li>
								<li><a href="{{ url('/') }}/add-bank-details"><i class="fa fa-caret-right"></i>Add Bank Details</a></li>
								 <li><a href="{{ url('/') }}/change-passwords"><i class="fa fa-caret-right"></i>Change Password</a></li>
                                <li><a href="{{ url('/') }}/news-alerts"><i class="fa fa-caret-right"></i>News Alert</a></li>	
                            </ul>
                        </li>
                        @endif
                    </ul>
                    <!--End widget-->
                </div>
            </div>
        </div>
        <!--================================-->
        <!--End menu-->
    </div>
</nav>
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