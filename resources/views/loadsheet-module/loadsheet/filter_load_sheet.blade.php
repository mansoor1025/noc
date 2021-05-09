  <table class="table table-bordered">
    <thead>
      <tr>
        <th>S.no</th>
        <th>Parcel No</th>
        <th>Consignee Name</th>
		<th>Consignee City</th>
		<th>COD Amount</th>
		<th>Status</th>
		<th>Created at</th>
      </tr>
    </thead>
    <tbody>
	  <?php 
			$count = 0;
			$total_cod_amount = 0;
		?>
	  @if($filter_sheet->count() > 0)
		@foreach($filter_sheet->get() as $value)
		<?php 
			
			 $count++;
			 $parcel_detail = DB::table('parcels')->where('tracking_id',$value->tracking_id)->first();
			 $total_cod_amount += $parcel_detail->cod_amount;	
		 ?>
			<tr>
				<td>{{$count}}</td> 
				<td>{{$value->tracking_id}}</td>
				<td>{{$parcel_detail->user_name}}</td>
				<td>{{$parcel_detail->destination_city}}</td>
				<td>{{$parcel_detail->cod_amount}}</td>
				@if($value->load_sheet_status == '7') 
					<td style="color:red;">Not Cleared</td> 
				@else
					<td style="color:red;">Cleared</td>	
				@endif
				<td>{{date("d-m-Y", strtotime($value->created_at))}}</td> 
			</tr>
			
		@endforeach
		   <tr>
				<th colspan="3">Total Parcel</th>
				<th>{{$count}}</th>
				<th colspan="2">Total COD Amount</th>
				<th>{{$total_cod_amount}}</th>
			</tr>
	  @else 
			<tr>
				<td colspan="7" class="text-center">No Record Found</td> 
			</tr>	
      @endif
    </tbody>
  </table>