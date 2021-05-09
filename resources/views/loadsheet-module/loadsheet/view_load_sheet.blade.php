<style>
.salary-slip{
      margin: 15px;
      .empDetail {
        width: 100%;
        text-align: left;
        border: 2px solid black;
        border-collapse: collapse;
        table-layout: fixed;
      }
      
      .head {
        margin: 10px;
        margin-bottom: 50px;
        width: 100%;
      }
      
      .companyName {
        text-align: right;
        font-size: 25px;
        font-weight: bold;
      }
      
      .salaryMonth {
        text-align: center;
      }
      
      .table-border-bottom {
        border-bottom: 1px solid;
      }
      
      .table-border-right {
        border-right: 1px solid;
      }
      
      .myBackground {
        padding-top: 10px;
        text-align: left;
        border: 1px solid black;
        height: 40px;
      }
      
      .myAlign {
        text-align: center;
        border-right: 1px solid black;
      }
      
      .myTotalBackground {
        padding-top: 10px;
        text-align: left;
        background-color: #EBF1DE;
        border-spacing: 0px;
      }
      
      .align-4 {
        width: 25%;
        float: left;
      }
      
      .tail {
        margin-top: 35px;
      }
      
      .align-2 {
        margin-top: 25px;
        width: 50%;
        float: left;
      }
      
      .border-center {
        text-align: center;
      }
      .border-center th, .border-center td {
        border: 1px solid black;
      }
      
      th, td {
        padding-left: 6px;
      }
}
@media print {
  body * {
    visibility: hidden;
  }
  #section-to-print, #section-to-print * {
    visibility: visible;
  }
  #section-to-print {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>
<?php
  use App\Customer;	
  $u_id = Auth::user()->id;
  $customer = Customer::where('user_id', $u_id)->first();
  $customer_id = $customer->id;
  
?>
			@if(count($parcel_detail) > 0)
			<table class="table table-striped" style="margin-left: 68px; width: 92%;">
                            <thead>
                              <tr>
                                <th scope="col">S.no</th>
                                <th scope="col">Parcel No</th>
                                <th scope="col">Consignee Name</th>
                                <th scope="col">Consignee City</th>
                                <th scope="col">COD Amount</th>
								<th scope="col">Created at</th>
                              </tr>
                            </thead>
                            <tbody>
								<?php 
									$count = 0;
									$total_cod_amount = 0;
									$check_array = '';
								?>
                                @foreach ($parcel_detail as $key=> $value)
								  
								 <?php
									$check_array .= $value->tracking_id.'_';
									$count++;
									$total_cod_amount += $value->cod_amount;
									?>
                                    <tr>
                                        <th>{{ $count }}</th>
                                        <td>{{ $value->tracking_id }}</td>
                                        <td>{{ $value->user_name }} </td>
                                        <td>{{ $value->destination_city}}</td>
                                        <td>{{ $value->cod_amount }}</td>
										<td>{{  date("d-m-Y", strtotime($value->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
							<tr>
								<th class="text-center" colspan="1">Total Parcel</th>
								<td class="text-center">{{$count}}</td>
								<th class="text-center" colspan="1">Total COD Amount</th>
								<th class="text-center">{{$total_cod_amount}}</th>
							</tr>
			  </table>
				  <div> 
					<button type="button" name="process" id="process" class="btn btn-success" style="margin-left: 78px;">Process</button>
				  </div>
			@endif
		<div id="salary-slip" style="display:none;" class="container-fluid">
			<img src="{{ asset('assets/img/noc-logo-md.png') }}" height="35" width="80" alt="" />
            <table class="table table-striped" style="margin-left: 68px; width: 92%;">
				<thead>
				  <tr>
					<th scope="col">S.no</th>
					<th scope="col">Parcel No</th>
					<th scope="col">Consignee Name</th>
					<th scope="col">Consignee City</th>
					<th scope="col">COD Amount</th>
					<th scope="col">Created at</th>
				  </tr>
				</thead>
				<tbody id="datas"> 
				</tbody>
				<tr>
					<th>Total Parcel</th>
					<th id="total_parcel"></th>
					<th>Total COD Amount</th>
					<th id="grand_cod_amount"></th>
				</tr>
			  <tr class="spacer"></tr>
			  <tr class="spacer"></tr>
			  <tr class="spacer"></tr>
			  <tr>
                <th>
                  Receiver Sign : 
				</th>
                <td>
                  ______________________
				</td>
				
				<th>
                  Receiver Name : 
				</th>
                <td>
                  ______________________
				</td>
              </tr>
			  
              
            </table>
	</div> 
<script>
  $("#process").click(function(e){
	  e.preventDefault();
	 
	  $.ajax({
		 type:'GET',
		 url:'<?php echo url('/') ?>/load-sheet-process',
		 data:{},
		 success:function(data){
			 if(data.status == 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1800
                        });
						$("#tracking_id").val('');
						view_load_sheet()
				}
				else if(data.status == 'load_exists'){
					Swal.fire({
						icon: 'error',
						title: data.message,
						showConfirmButton: false,
						timer: 1800
					});
			   }
			   print_load_Sheet() 
		 } 	
	  });
  });
     
  function print_load_Sheet(){
	   var check_array = '<?php echo $check_array ?>';
	  $.ajax({
		 type:'GET',
		 url:'<?php echo url('/') ?>/print-load-Sheet',
		 data:{check_array:check_array},
		 success:function(res){
			var arr = JSON.parse(res);
			console.log(arr);
			
			var  count= 0;
			var cod_amount = 0;
			var load_sheet_date = '';
			 $.each(arr , function (index, value){ 
			  count++;
			  cod_amount += value.cod_amount;
					console.log(value);
				   $("#datas").append('<tr><td>'+count+'</td><td>'+value.tracking_id+'</td><td>'+value.user_name+'</td><td>'+value.destination_city+'</td><td>'+value.cod_amount+'</td><td>'+value.created_at+'</td></tr>')
				   load_sheet_date = value.created_at; 
				}); 
			  console.log(cod_amount);		
			  $("#total_parcel").html(count);
			  $("#grand_cod_amount").html(cod_amount); 
			  //$("#salary-slip").show(); 
			  printDiv('salary-slip') 
		 }	
	  });
  } 
  
  function printDiv(divName) { 
     var printContents = document.getElementById(divName).innerHTML;
     //var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();
	 location.reload() 
     //document.body.innerHTML = originalContents; 
	// $("#salary-slip").hide();
 }
</script>				  