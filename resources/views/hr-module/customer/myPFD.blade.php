<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<style>
    body{
        font-family: Arial, Helvetica, sans-serif;
    }
    hr{
        margin-top: -40px;
        width: 88%;
        margin-left: 90px
    }
    h3{
        font-size: 20px;
        text-align: center; 
        text-decoration: underline; 
        margin-top: -28px
    }
    .top{
        font-size: 15px
    }
    .info{
        padding: 5px;
        margin-left: -100px
    }
    .summary{
        border: 1px solid black;
        border-collapse: collapse;
    }
    .size{
        text-align: center;
        font-size: 12px;
    }
    .parcel{
        font-size: 10px
    }
	#pagetitle.pagetitle {
    padding-top: 175px;
    padding-bottom: 155px;
}
	#site-header-wrap .site-branding img {
    max-height: 117px !important;
    max-width: inherit;
    height: 103px !important;
}
.btn, button, .button, input[type="submit"] {
    background-color: #a2b51c;
    font-size: 14px;
    color: #fff;
    text-transform: capitalize;
    padding: 0 27px;
    line-height: 46px;
    -webkit-transition: all 300ms linear 0ms;
    -khtml-transition: all 300ms linear 0ms;
    -moz-transition: all 300ms linear 0ms;
    -ms-transition: all 300ms linear 0ms;
    -o-transition: all 300ms linear 0ms;
    transition: all 300ms linear 0ms;
    -webkit-border-radius: 2px;
    -khtml-border-radius: 2px;
    -moz-border-radius: 2px;
    -ms-border-radius: 2px;
    -o-border-radius: 2px;
    border-radius: 2px;
    position: relative;
    display: inline-block;
    text-align: center;
    cursor: pointer;
    font-weight: 700;
    border: 2px solid #654c40;
}
.cms-fancy-box-layout3 .item-icon svg {
    height: 56px;
    width: auto;
    fill: #718a09;
    transition: all 300ms ease 0s;
}
.footer-logo img {
    max-height: 107px;
    width: 132px !important;
}
.elementor-social-icon {
    background-color: #a2b51c !important;
    font-size: 16px;
    padding: 0.56em;
}
.avatar-border img {
    padding: 2px;
    background-color: #fff;
    border: 2px solid #605c51 !important;
    border-radius: 50% !important;
}
li.lang-item {
    display: none;
}
.cms-service-carousel1 .entry-title {
    font-size: 21px;
    line-height: 29px;
    margin: 0 0 31px;
    padding-right: 20%;
}
#rev_slider_1_1_wrapper .theme-custom .tp-bullet.selected {
    background: #605c51;
}
.nice-select {
    margin: 12px;
}
.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}
.primary-menu > li > a, body .primary-menu .sub-menu li a{font-display:swap;}body #pagetitle{background-image:url('https://perfecteditings.co.uk/NOC/wp-content/uploads/2020/03/ptt_default.jpg');}body #pagetitle h1.page-title,body #pagetitle .page-title-inner .cms-breadcrumb{color:#ffffff;}#pagetitle.pagetitle{padding-top:375px;padding-bottom:275px;}a{color:inherit;}a:hover{color:#e11d07;}a:active{color:#e11d07;}body{font-display:swap;}h1,.h1,.text-heading{font-display:swap;}h2,.h2{font-display:swap;}h3,.h3{font-display:swap;}h4,.h4{font-display:swap;}h5,.h5{font-display:swap;}h6,.h6{font-display:swap;}
</style>
<body>
	<?php 
	$customer_detai = DB::table('customers')->where('id',$data)->first();
	$user_data = DB::table('users')->where('id',$customer_detai->user_id)->first();
	?>
    <br>
    <img src="assets/img/noc-logo-md.png" alt="Profile Picture" width="260">
    <hr>
    <h3>User Registration Detail</h3>
    <br>
    <table width="50%">
		
        <tr>
            <td class="info top"><strong>Full Name: </strong></td>
            <td class="info top"> {{ $customer_detai->full_name }}</td>
        </tr>
        <tr>
            <td class="info top"><strong>Company Name:</strong></td>
            <td class="info top">{{ $customer_detai->company_name }}</td>
        </tr>
        <tr>
            <td class="info top"><strong>Username:</strong></td>
            <td class="info top">{{ $user_data->full_name }}</td>
        </tr>
		<tr>
            <td class="info top"><strong>Email:</strong></td>
            <td class="info top">{{ $user_data->email }}</td>
        </tr>
		<tr>
            <td class="info top"><strong>Mobile Number:</strong></td>
            <td class="info top">{{ $user_data->mobile_number }}</td>
        </tr>
		<tr>
            <td class="info top"><strong>CNIC:</strong></td>
            <td class="info top">{{ $customer_detai->cnic }}</td>
        </tr>
		<tr>
            <td class="info top"><strong>City :</strong></td>
            <td class="info top">{{ $customer_detai->city }}</td>
        </tr>
		<tr>
            <td class="info top"><strong>Bank :</strong></td>
            <td class="info top">{{ $customer_detai->bank }}</td>
        </tr>
		<tr>
            <td class="info top"><strong>Bank Branch:</strong></td>
            <td class="info top">{{ $customer_detai->bank_branch }}</td>
        </tr>
		<tr>
            <td class="info top"><strong>Account Title:</strong></td>
            <td class="info top">{{ $customer_detai->account_title }}</td>
        </tr>
		<tr>
            <td class="info top"><strong>Date Of Birth:</strong></td>
            <td class="info top">{{ date("d-m-Y", strtotime($customer_detai->birth_date)) }}</td>
        </tr>
		<tr>
            <td class="info top"><strong>Anniversary Date*:</strong></td>
            <td class="info top">{{ date("d-m-Y", strtotime($customer_detai->anniversary_date)) }}</td>
        </tr>
		<tr>
            <td class="info top"><strong>Address*:</strong></td>
            <td class="info top">{{ $customer_detai->residental_address }}</td>
        </tr>
		<tr>
            <td class="info top"><strong>Shipper Address*:</strong></td>
            <td class="info top">{{ $customer_detai->shipper_address }}</td>
        </tr>
 
    </table>

    <p style="page-break-after: always;">&nbsp;</p>
	<div class="elementor-row">
                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-7bc9844" data-id="7bc9844" data-element_type="column">
            <div class="elementor-column-wrap elementor-element-populated">
                            <div class="elementor-widget-wrap">
                		<div class="elementor-element elementor-element-678f962 elementor-widget elementor-widget-html" data-id="678f962" data-element_type="widget" data-widget_type="html.default">
				<div class="elementor-widget-container">
					</div>
				</div>
				<div class="elementor-element elementor-element-400c2e6 elementor-widget elementor-widget-cms_heading" data-id="400c2e6" data-element_type="widget" data-widget_type="cms_heading.default">
				<div class="elementor-widget-container">
			<div class="cms-heading-wrapper cms-heading-layout1">
    
            <h2 class="custom-heading">
            <span>Terms &amp; Conditions</span>
        </h2>
        
    </div>		</div>
				</div>
		<div class="elementor-element elementor-element-fb62104 elementor-widget elementor-widget-text-editor" data-id="fb62104" data-element_type="widget" data-widget_type="text-editor.default">
			<div class="elementor-widget-container">
				<div class="elementor-text-editor elementor-clearfix"><p>By tendering material for shipment in NOC /TRUST PAKISTAN courier Service or part &amp; parcel transit service the shipper agrees to the term and condition stated herein and to NOC/TRUST PAKISTAN’s standard conditions of carriage which are incorporated into the contact by reference and which are from or inspection at any NOC/TRUST PAKISTAN office. No agent or employee of NOC/TRUST PAKISTAN or the shipper may alter or modify these term &amp; condition.</p>
					<h4><strong>The NOC/TRUST PAKISTAN Customer Web Portal Consignment Note: </strong></h4>
					<p>The NOC/TRUST PAKISTAN consignment note generated through customer web portal is Non-Negotiable and the shipper acknowledges that it has been prepared by the shipper or by NOC/TRUST PAKISTAN on behalf of the shipper. The shipper warrants that it is the owner of the goods transported hereunder or it is the authorized agent of the owner of the goods and that it hereby accepts NOC/TRUST PAKISTAN’s terms &amp; conditions for itself and as agent for and on behalf of any other person having any interest in the shipment.</p>
					<h4><strong>Shipper’s Obligations and Acknowledgements: </strong></h4>
					<p>The shipper warrants the each article in the shipment is properly described on the NOC/TRUST PAKISTAN consignment note and the shipment details are complete and accurate and the shipment has not been declared by NOC/TRUST PAKISTAN to be unacceptable for transportation and that the shipment is properly marked and addressed and packed to ensure safe transportation.</p>
					<p><strong style="color: rgb(96, 92, 81); font-family: Rubik, sans-serif; font-size: 25px; letter-spacing: 0px;">Right of Inspection of Shipment:</strong><br></p>
					<p><span style="color: inherit; font-family: inherit; font-weight: inherit; letter-spacing: 0px;">NOC/TRUST PAKISTAN has the right, but not the obligation, to inspect any shipment including, without limitation, opening the shipment. The shipper agrees that NOC/TRUST PAKISTAN may open and inspect a shipment for any reason at any time.</span><br></p>
					<p><strong>&nbsp;</strong><strong style="color: rgb(96, 92, 81); font-family: Rubik, sans-serif; font-size: 25px; letter-spacing: 0px;">Lien of Goods Shipped:</strong></p>
					<p>NOC/TRUST PAKISTAN shall have a lien on any goods shipped for all freight Charges, Octroi, duties, advances or any other charges of any kind arising out of the transpiration hereunder and may refuse to surrender possession of the goods until such charges are paid.</p>
					<p><strong style="letter-spacing: 0px; color: rgb(96, 92, 81); font-family: Rubik, sans-serif; font-size: 25px;">Limitation of Liability:</strong></p>
					<div><span style="color: inherit; font-family: inherit; font-weight: inherit; letter-spacing: 0px;">The liability of NOC/TRUST PAKISTAN for any loss or damage to the shipment (which terms shall include all documents or parcels consigned to NOC/TRUST PAKISTAN under the NOC/TRUST PAKISTAN consignment note) is limited to Rs. 100/- (Rupee One Hundred only in case of all shipment with origin and destination within Pakistan) or less.The amount of loss or damage to a document or parcel actually sustained, or The actual value of the document or parcel as determined under section 6 hereof, without regard to its commercial utility or special value to the shipper.</span><br></div>
					<p><strong style="letter-spacing: 0px; color: rgb(96, 92, 81); font-family: Rubik, sans-serif; font-size: 25px;">Consequential Damages Exclude:</strong><br></p>
					<p>NOC/TRUST PAKISTAN shall not be liable in any consequential or special damages or other indirect loss. However arising, whether or not NOC/TRUST PAKISTAN had knowledge that such damages might be incurred, including but limited to loss of income, profit, interest, use of contents or loss of market.</p>
					<h4><strong>Liabilities Not Assumed: </strong></h4>
					<p>While NOC/TRUST PAKISTAN endeavor to exercise its best efforts to provide expeditious deliver in accord with regular delivery schedule, NOC/TRUST PAKISTAN will not, under any circumstances be liable for delay in pick up, transport or delivery of any shipment regardless of the cause of such delay. Further NOC/TRUST PAKISTAN shall not liable if a shipment is lost damaged, mis-delivered or not delivered because of circumstances beyond our control. These include</p>
					<p>“Act of God” for example earthquake, cyclone, storm, flood or “force majeure” for example war, plane crash or embargo or caused by mishap with NOC/TRUST PAKISTAN</p>
					<p>The act, default or omission of the shipper, the or any other party who claims an interest in the shipment (include violation of any terms and condition hereof) or any person other than NOC/TRUST PAKISTAN or of any Government officials or of the Postal service forwarded or other entity or person to whom a shipment is tendered by NOC/TRUST PAKISTAN or transportation to any location not regularly served by NOC/TRUST PAKISTAN regardless of whether the shipper reported or had knowledge of such third party delivery arrangements.</p>
					<p>The nature of the shipment for any defect, characteristic, inherent vice thereof, even if know to us when we accepted it Electrical or magnetic energy erasure or other such damage to electronic or photographic images or recording in any form.</p>
					<h4><strong style="color: inherit; font-family: inherit; letter-spacing: 0px;">Claims:</strong></h4>
					<p>Any claim must be brought by the shipper and delivered in writing to the office of NOC/TRUST PAKISTAN nearest the location at which the shipment was accepted within 30 days of the date of such acceptance, no claim may be made against NOC/TRUST PAKISTAN outside if this time limit.</p>
					<p>No claim for loss or damage or theft will be entertained until all transportation charges have been paid. The amount of any claim may not be deducted from any transportation charges owed to NOC/TRUST PAKISTAN .</p>
					<p></p>
					<p>NOC/TRUST PAKISTAN pay to shipper 20% of declare cod amount , zero cod claim will not be entertain&nbsp;</p>
					<p></p>
					<p>NOC/TRUST PAKISTAN does not maintain records relevant to a shipment of more than 45 days. It will thereof be unable to refer to or produce any such record where it is notified for the same after expiry of the said period of 45 days from the date of shipment.</p>
					<h4><strong>Applicability: </strong></h4>
					<p>These term and conditions shall apply to and insure to benefit, or NOC/TRUST PAKISTAN , and its authorized and affiliated companies, and their officers, directors and employees.</p>
					<h4><strong>Material Not Acceptable For Transportation: </strong></h4>
					<p>NOC/TRUST PAKISTAN not accept as a shipment Currency, Jewelry, Bullion, Antiques, Liquor, Stamps, Precious Metals, Precious Stones, Work of Art, Fire arms, Plants, Drugs, Explosives, Animals, Perishable, Negotiable Instruments in bearer Form, Lewd, Obscene or Pornographic Materials, Industrial Carbons and Diamonds, items/articles restricted by IATA (International Air Transport Association) or ICAO(International Civil Aviation Organization), hazardous or combustible material, property of</p>
					<p>carriage of which is prohibited by any law, regulation or statute of any Provincial or Federal</p>
					<p>Govt. of Pakistan.</p>
					<p></p>
<p>Acceptance:<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u>Name of signatory<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u>Designation<u>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u>date</p></div>
				</div>
				</div>
		                </div>
                    </div>
        </div>
                                </div>
   
	  <footer>
	    <br>
		<br>
		<img src="assets/img/noc-logo-md.png" alt="Profile Picture" width="260">
		<hr>
	  </footer>

</body>
</html>