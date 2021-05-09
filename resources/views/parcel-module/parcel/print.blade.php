<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0075)file:///C:/Users/Shehryar%20saeed/Desktop/TCS%20__%20Customer%20Portal.html -->
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>
            TCS :: Customer Portal
        </title>
        <script
            type="text/javascript"
            src="./tcs slip_files/ruxitagentjs_ICA2SVfhqr_10157181213164340.js.download"
            data-dtconfig="rid=RID_1092628111|rpid=-1604494064|domain=tcscourier.com|reportUrl=/COD/rb_f51a33a4-ce9b-462e-b848-ffec66bd15d1|srms=1,1,,,|uxrgcm=100,25,300,3;100,25,300,3|featureHash=ICA2SVfhqr|md=1=a#txtLogin@value|srad=1|lastModification=1546877507480|dtVersion=10157181213164340|tp=500,50,0,1|rdnt=1|uxrgce=1|agentUri=/COD/ruxitagentjs_ICA2SVfhqr_10157181213164340.js"
        ></script>
        <script type="text/javascript" src="./tcs slip_files/jquery.1.4.2.min.js.download"></script>
        <script type="text/javascript" src="./tcs slip_files/jquery-barcode.js.download"></script>
        <script type="text/javascript" src="./tcs slip_files/qrcode.js.download"></script>
        <script language="javascript" type="text/javascript">
            function getQueryStrings() {
                //Holds key:value pairs
                var queryStringColl = null;

                //Get querystring from url
                var requestUrl = window.location.search.toString();

                if (requestUrl != "") {
                    //window.location.search returns the part of the URL
                    //that follows the ? symbol, including the ? symbol
                    requestUrl = requestUrl.substring(1);

                    queryStringColl = new Array();

                    //Get key:value pairs from querystring
                    var kvPairs = requestUrl.split("&");

                    for (var i = 0; i < kvPairs.length; i++) {
                        var kvPair = kvPairs[i].split("=");
                        queryStringColl[kvPair[0]] = kvPair[1];
                    }
                }

                return queryStringColl;
            }

            function PrintNow() {
                var myvar = document.getElementById("pId");
                document.url = "none";
                var i = 1;
                //	for (i; i==2; i++) {
                if (navigator.userAgent.indexOf("Netscape6") != -1) {
                    myvar.style.visibility = "hidden";
                    window.print();
                    myvar.style.visibility = "visible";
                } else {
                    myvar.style.display = "none";
                    var mybrowser = "<OBJECT ID='brwsr' WIDTH=0 HEIGHT=0 CLASSID='CLSID:8856F961-340A-11D0-A96B-00C04FD705A2'> </OBJECT>";
                    document.body.insertAdjacentHTML("beforeEnd", mybrowser);
                    brwsr.ExecWB(6, -1);
                    brwsr.ExecWB(6, -1);
                    //window.print();
                    myvar.style.display = "";
                }
                //}
                return false;
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                var queryStringColl = getQueryStrings();

                var BarCodeCodAmount = 0;
                debugger;
                $("#barcode").html("").show().barcode(queryStringColl["CN"], "code128", { showHRI: true, barHeight: 25 });
                $("#barcodec").html("").show().barcode(queryStringColl["CN"], "code128", { showHRI: true, barHeight: 25 });
                $("#barcodea").html("").show().barcode(queryStringColl["CN"], "code128", { showHRI: true, barHeight: 25 });

                $("#CodAmountBarcodea")
                    .html("")
                    .show()
                    .barcode("RS" + BarCodeCodAmount + "", "code128", { showHRI: true, barHeight: 25, fontSize: 11 });
                $("#CodAmountBarcodeb")
                    .html("")
                    .show()
                    .barcode("RS" + BarCodeCodAmount + "", "code128", { showHRI: true, barHeight: 25, fontSize: 11 });
                $("#CodAmountBarcodec")
                    .html("")
                    .show()
                    .barcode("RS" + BarCodeCodAmount + "", "code128", { showHRI: true, barHeight: 25, fontSize: 11 });

                //			    var create_qrcode = function (text, typeNumber, errorCorrectLevel, table) {
                //			        var qr = qrcode(typeNumber || 4, errorCorrectLevel || 'M');
                //			        qr.addData(text);
                //			        qr.make();
                //			        return qr.createImgTag();
                //			    };
            });
        </script>
        <style type="text/css">
            .tab {
                border-color: gray;
                border-width: 1px 1px 0px 0px;
                border-style: solid;
            }

            .tdl {
                border-color: gray;
                border-width: 0px 0px 1px 1px;
                border-style: solid;
                margin: 0;
                padding: 4px;
            }

            .tdl1 {
                border-color: gray;
                border-width: 0px 0px 0px 1px;
                border-style: solid;
                margin: 0;
                padding: 4px;
            }
			@media print {
			   .myelement1 {
				background-color: red;
				}
			}
        </style>
    </head>
    <body>
		<?php
			$shipping_name = DB::table('shipping_partners')->where('id',$parcel->shipping_partner_id)->value('name');
			$consumer_detail = DB::table('users')->where('id',Auth::user()->id)->first();
			$customers = DB::table('customers')->where('user_id',Auth::user()->id)->first();
		?>
        <form  method="post" action="http://webapp.tcscourier.com/COD/cnprn.aspx?CN=772348950833" id="form1">
            <div class="aspNetHidden">
                <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwUKMTU4OTE0ODk0M2Rk59+fBVnM3SnCN+1cFEmGBVio53WGAoK6QyS4PKLHtoE=" />
            </div>

            <div class="aspNetHidden">
                <input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="09026168" />
            </div>
            <table style="width: 660px;">
                <tbody>
                    <tr>
                        <td>
                            <table style="width: 660px;" class="myelement1">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="tab" cellpadding="0" cellspacing="0" style="font-size: 10px; font-family: arial;">
                                                <tbody>
                                                    <tr>
                                                        <td rowspan="3" class="tdl" width="85">
                                                            &nbsp;<img src="{{ asset('assets/img/noc-logo-md.png') }}" height="35" width="80" alt="" /><br />
                                                            <span style="font-size: 7px;">&nbsp;&nbsp;NOC</span>
															<hr>
															@if($shipping_name == 'TCS')
															 &nbsp;<img src="{{ asset('assets/img/tcs.png') }}" height="35" width="80" alt="" /><br />
                                                            <span style="font-size: 7px;">&nbsp;&nbsp;Tcs</span>
															@endif
                                                        </td>
                                                        <td rowspan="3" valign="bottom" width="85" class="tdl" align="center">
                                                            <div id="barcodec" style="padding: 0px; overflow: auto; width: 121px;">
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 10px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 2px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 2px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 3px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 2px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 4px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 3px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 3px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 2px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 3px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 3px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 3px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 2px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 4px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 3px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 3px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 2px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 2px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 2px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 3px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 2px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 3px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 2px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 2px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 4px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 2px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 3px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 3px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 2px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 10px;"></div>
                                                                <div style="clear: both; width: 100%; background-color: #ffffff; color: #000000; text-align: center; font-size: 10px; margin-top: 5px;">{{ $parcel->tracking_id }}</div>
                                                            </div>
                                                            <span style="font-size: 9px;">Consignee Copy</span>
                                                        </td>
                                                        <td class="tdl" width="60">
                                                            Date
                                                        </td>
                                                        <td class="tdl">
                                                            {{ date('d-M-Y', strtotime($parcel->created_at)) }}
                                                        </td>
                                                        <td class="tdl">
                                                            Time
                                                        </td>
                                                        <td class="tdl">
                                                            {{ $parcel->created_at->format('H:i') }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tdl">
                                                            Service
                                                        </td>
                                                        <td class="tdl">
                                                            OVERNIGHT
                                                        </td>
                                                        <td class="tdl"></td>
                                                        <td class="tdl"></td>
                                                    </tr>
                                                    <tr> 
                                                        <td class="tdl">
                                                            Origin
                                                        </td>
                                                        <td class="tdl">
                                                            KHI
                                                        </td>
                                                        <td class="tdl">
                                                            Destination
                                                        </td>
                                                        <td class="tdl">
                                                            <?php 
																$des_code = DB::table('api_cities')->where('city_name',$parcel->destination_city)->value('city_code');
																echo $des_code;
															?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tdl">
                                                            &nbsp;Shipper
                                                        </td>
                                                        <td colspan="2" class="tdl1">
                                                            &nbsp;{{ $parcel->customer->full_name }}
                                                        </td>
                                                        <td class="tdl">
                                                            &nbsp;Consignee
                                                        </td>
                                                        <td colspan="2" class="tdl1">
                                                            &nbsp;{{ $parcel->user_name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="tdl" valign="top" width="290">
                                                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;  LTA 4 AMMA TOWER SADDAR KARACHI<br />
                                                            <br />
                                                            {{ $parcel->customer->email }}<br />
                                                        </td>
                                                        <td colspan="3" class="tdl" width="340">
                                                            {{ $parcel->user_address }}<br />
                                                            {{ $parcel->mobile_no }}<br />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tdl" style="font-weight: bold; font-size: small;">&nbsp;Pieces <span class="tdl1">&nbsp;&nbsp;1</span></td>
                                                        <td class="tdl">&nbsp;Weight &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="tdl1">&nbsp;&nbsp;{{ $parcel->weight }}</span></td>
                                                        <td class="tdl">
                                                            &nbsp;Fragile
                                                        </td>
                                                        <td class="tdl">
                                                            &nbsp; YES
                                                        </td>
                                                        <td class="tdl">
                                                            &nbsp;
                                                        </td>
                                                        <td class="tdl">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tdl" colspan="2">
                                                            &nbsp;Declared Insurance Value
                                                        </td>
                                                        <td class="tdl"></td>
                                                        <td class="tdl" style="font-weight: bold; font-size: small;">
                                                            COD AMOUNT
                                                        </td>

                                                        <td class="tdl" colspan="2" valign="bottom" align="center" style="font-weight: bold;">
                                                            <div id="CodAmountBarcodea" style="padding: 0px; overflow: auto; width: 88px;">
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 10px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 2px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 2px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 4px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 2px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 3px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 3px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 2px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 3px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 3px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 2px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 3px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 2px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 2px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 4px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 3px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 2px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 3px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 3px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 1px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 1px;"></div>
                                                                <div style="float: left; font-size: 0px; width: 0; border-left: 2px solid #000000; height: 25px;"></div>
                                                                <div style="float: left; font-size: 0px; background-color: #ffffff; height: 25px; width: 10px;"></div>
                                                                <div style="clear: both; width: 100%; background-color: #ffffff; color: #000000; text-align: center; font-size: 11px; margin-top: 5px;">RS {{ $parcel->cod_amount }}</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tdl" style="font-weight: bold; font-size: small;">
                                                            Product Detail
                                                        </td>
                                                        <td class="tdl" colspan="5" style="font-weight: bold; font-size: small;">
														  {{$parcel->product_detail}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tdl" style="font-weight: bold; font-size: small;">
                                                            &nbsp;Remarks
                                                        </td>
                                                        <td class="tdl" colspan="5" style="font-weight: bold; font-size: small;">
                                                            MUST CALL TO CONSIGNEE BEFORE THE DELIVERY
                                                        </td>
                                                    </tr>
													<tr>
                                                        <td class="tdl">
                                                            &nbsp;Customer Ref. #
                                                        </td>
                                                        <td class="tdl" colspan="4">
															{{$parcel->reference_no}}
                                                        </td>
                                                        <td class="tdl" align="right"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tdl" style="font-weight: bold; font-size: small;">
                                                            &nbsp;Sender Address
                                                        </td>
                                                        <td class="tdl" colspan="4">
                                                           {{ $customers->shipper_address }}
                                                        </td>
                                                        <td class="tdl" align="right"></td>
                                                    </tr>
													
                                                    <tr>
                                                        <td class="tdl" colspan="6" align="center">
                                                            <b>Please don't accept, if shipment is not intact. Before paying the COD, shipment can not be open.</b>
                                                            <br />

                                                            Incase of complaints, pls contact to {{ $parcel->customer->shipper_address }}<br />
                                                            Ph: {{ $parcel->customer->mobile_no_1 }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr> 
                    <tr>
                        <td align="center">
                            --------------------------------------------------------------------------------------
                        </td>
                    </tr>
                </tbody>
            </table>

            <input type='button' id='btn' value='Print' onclick='printDiv();'>
        </form>

        <script type="text/javascript">
            function printDiv() {
                var divToPrint = document.getElementById("form1");

                var newWin = window.open("", "Print-Window");

                newWin.document.open();

                newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + "</body></html>");

                newWin.document.close();

                setTimeout(function () {
                    newWin.close();
                }, 10);
            }
        </script>
    </body>
</html>
