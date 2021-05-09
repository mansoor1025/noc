  <table class="table table-bordered">
    <thead>
      <tr>
	    <th></th> 
        <th>S.no</th>
        <th>Parcel No</th>
		<th>Change P No</th>
		<th>Company Name</th>
		<th>Weight</th>
        <th>Consignee Name</th>
		<th>Consignee City</th>
		<th>Consignee Email</th>
		<th>Consignee Cell No</th>
		<th>COD Amount</th>
		<th>Created at</th>
      </tr>  
    </thead>
    <tbody>
	  <?php 
			$count = 0;
			$total_cod_amount = 0;
		?>
	  @if($filter_validate->count() > 0)
		@foreach($filter_validate->orderBy('load_sheets.id','desc')->get() as $value)
		<?php 
			 $count++;
			 $customer_name = DB::table('customers')->where('id',$value->customer_id)->first();
			 $total_cod_amount += $value->cod_amount;	
		 ?>
			<tr @if($value->load_sheet_status == 6) style="background-color: #69de69;"@endif>
			  @if($value->province_name == 'Sindh' || $value->province_name == 'Balochistan')

			    <td><input type="checkbox" name="noc_check_box" disabled value="{{$value->tracking_id}}"></td>
			  @elseif($value->service_type == 'deal_pakistan')  
			    <td></td>
			  @else
			    <td><input type="checkbox" name="noc_check_box" id="noc_check_box" class="noc_check_box" value="{{$value->tracking_id}}" checked></td>
			  @endif
				
				<td>{{$count}}</td> 
				<td>{{$value->tracking_id}}</td>
				<td>
					@if($value->new_tracking_id != '')	
						{{$value->new_tracking_id}}
					@else
						-
					@endif
				</td>
				<td>{{$customer_name->company_name}}</td>
				<td>{{$value->weight}}</td>
				<td>{{$value->user_name}}</td>
				<td>{{$value->destination_city}}</td>
				@if($value->email != '')
					<td>{{$value->email}}</td>
				@else	
					 <td>-</td>
				@endif 
				<td>{{$value->mobile_no}}</td>
				<td>{{$value->cod_amount}}</td>
				<td>{{date("d-m-Y", strtotime($value->created_at))}}</td> 
			</tr>
			
		@endforeach
		   <tr>
				<th colspan="3">Total Parcel</th>
				<th>{{$count}}</th>
				<th colspan="5">Total COD Amount</th>
				<th>{{$total_cod_amount}}</th>
			</tr>
	  @else 
			<tr>
				<td colspan="" class="text-center">No Record Found</td> 
			</tr>	
      @endif
    </tbody>
  </table>