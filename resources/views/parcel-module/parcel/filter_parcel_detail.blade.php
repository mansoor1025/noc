  <table class="table table-bordered">
    <thead>
      <tr>
        <th>S.no</th>
        <th>Company Name</th>
		<th>shipping Partner Name</th>
        <th>Consignee Name</th>
		<th>Consignee City</th>
		<th>Consignee Email</th>
		<th>Consignee Cell No</th>
		<th>Tracking ID</th>
		<th>Change P No</th>
		<th>Weight</th>
		<th>Reference No</th>
		<th>COD Amount</th>
		<th>Created at</th>
      </tr>
    </thead>
    <tbody>
	  <?php 
			$count = 0;
			$total_cod_amount = 0;
		?>
	  @if($parceldetail->count() > 0)
		@foreach($parceldetail->get() as $value)
		<input type="hidden" id="shipping_id_{{$value->id}}" value="">
		<input type="hidden" id="des_city_{{$value->id}}" value="{{$value->destination_city}}">
		<?php 
			
			 $count++; 
			 $customer_name = DB::table('customers')->where('id',$value->customer_id)->first();
			 $total_cod_amount += $value->cod_amount;
			 	
		 ?>
			<tr @if($value->weight_updated_date != '') style="background-color: #ec8787;"@endif>
				<td>{{$count}}</td> 
				<td>{{$customer_name->company_name}}</td>
				<td>
					@if($value->shipping_partner_id == 1)
						NOC 
					@else
						TCS
					@endif	
				</td>
				<td>{{$value->user_name}}</td>
				<td>{{$value->destination_city}}</td>
				@if($value->email != '')
					<td>{{$value->email}}</td>
				@else	
					 <td>-</td>
				@endif 
				<td>{{$value->mobile_no}}</td>
				<td>{{$value->tracking_id}}</td>
				<td> 
					@if($value->new_tracking_id != '')	
						{{$value->new_tracking_id}}
					@else
						-
					@endif
				</td>
				<td><input type="number" min="0" name="weight" id="weight" class="form-control" value="{{$value->weight}}" onchange="change_weight({{$value->id}},this.value)" style="width: 65px;"></td>
				<td>{{$value->reference_no}}</td>
				<td>{{$value->cod_amount}}</td>
				<td>{{date("d-m-Y", strtotime($value->created_at))}}</td> 
			</tr>
			
		@endforeach
		   <tr>
				<th colspan="3">Total Parcel</th>
				<th>{{$count}}</th>
				<th colspan="4">Total COD Amount</th>
				<th>{{$total_cod_amount}}</th>
			</tr>
	  @else  
			<tr> 
				<td colspan="13" class="text-center">No Record Found</td> 
			</tr>	
      @endif
    </tbody> 
  </table>
  <script>
	function change_weight(id,weight){
		var des_city = $("#des_city_"+id).val(); 
		if(weight > 1){
			if(des_city == 'KARACHI' || des_city == 'HYDERABAD' || des_city == 'LAHORE'){
				$("#shipping_id_"+id).val(1);
			}
			else{
			    $("#shipping_id_"+id).val(2);
			}
		} 
		else{
			if(des_city == 'KARACHI' || des_city == 'HYDERABAD' || des_city == 'LAHORE'){
				$("#shipping_id_"+id).val(1);
			}
			else{
			    $("#shipping_id_"+id).val(2);
			}
		}
		var shipping_id = $("#shipping_id_"+id).val();

		$.ajax({
			type:'GET',
			url:'<?php echo url('/') ?>/change-weight',
			data:{id:id,weight:weight,shipping_id:shipping_id},
			success:function(data){
				
				if(data.status == true){
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
					filter_weight_correction()
			}	
		})
	}
 function filter_weight_correction(){ 
	 var from = $("#from").val();
	 var to = $("#to").val();
	 var parcel_no = $("#parcel_no").val();
	 var company_name = $("#company_name").val();
	 $.ajax({
		type:'GET',
		url:'<?php echo url('/') ?>/filter-weight-correction', 
		data:{from:from,to:to,parcel_no:parcel_no,company_name:company_name},
		success:function(res){
			$("#validate_result").html(res);
			//console.log(res);
		}	
	 });
 }
  </script>
  