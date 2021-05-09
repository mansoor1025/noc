			<table class="table table-striped" style="margin-left: 68px; width: 92%;">
                            <thead>
                              <tr>
                                <th scope="col">S.no</th>
                                <th scope="col">Parcel No</th>
                                <th scope="col">Consignee Name</th>
                                <th scope="col">Consignee City</th>
                                <th scope="col">Cdo Amount</th>
								<th scope="col">Created at</th>
                              </tr>
                            </thead>
                            <tbody>
								<?php 
									$count = 0;
									$total_cod_amount = 0;
								?>
                                @foreach ($parcel_detail as $key=> $value)
								 <?php 
									$count++;
									$total_cod_amount += $value->cod_amount;
									?>
                                    <tr>
                                        <th>{{ $count }}</th>
                                        <td>{{ $value->tracking_id }}</td>
                                        <td>{{ $value->user_name }}</td>
                                        <td>{{ $value->destination_city}}</td>
                                        <td>{{ $value->cod_amount }}</td>
										<td>{{ date('d-m-y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
							<tr>
								<td colspan="3">{{$count}}</td>
								<td colspan="3">{{$total_cod_amount}}</td>
							</tr>
                          </table>