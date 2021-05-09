<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
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
</style>
<body>
    <br>
    <img src="assets/img/noc-logo-md.png" alt="Profile Picture" width="260">
    <hr>
    <h3>NOC PAYMENT DETAIL</h3>
    <br>
    <table width="50%">
		
        <tr>
            <td class="info top"><strong>Account No: </strong></td>
            <td class="info top"> {{ $invoice->customer->account_title }}</td>
        </tr>
        <tr>
            <td class="info top"><strong>Consignee Name:</strong></td>
            <td class="info top">{{ $invoice->customer->full_name }}</td>
        </tr>
        <tr>
            <td class="info top"><strong>Address:</strong></td>
            <td class="info top">{{ $invoice->customer->shipper_address }}</td>
        </tr>
        <tr>
            <td class="info top"><strong>City:</strong></td>
            <td class="info top">{{ $invoice->customer->city }}</td>
        </tr>
        <tr>
            <td class="info top"><strong>Payment Period:</strong></td>
            <td class="info top">{{ $invoice->date }}</td>
        </tr>
        <tr>
            <td class="info top"><strong>Invoice Number:</strong></td>
            <td class="info top">{{ $invoice->id }}</td>
        </tr>
        <tr>
            <td class="info top"><strong>Reporting Date:</strong></td>
            <td class="info top">{{ date('d-M-Y') }}</td>
        </tr>
    </table>

    <br><br>
    <table class="summary" width="100%">
        <tr class="summary">
            <th class="summary" style="padding: 10px"><strong>INVOICE SUMMARY</strong></th>
            <th class="summary" style="padding: 10px"><strong>PAYMENT SUMMARY</strong></th>
        </tr>
        <tr class="summary">
            <td class="summary">
                <table width="90%">
                    <tr>
                        <td class="info size"><strong>Delivery Charges</strong></td>
                        <td class="info size">{{ $invoice->shipping_charges }}</td>
                    </tr>
                    <tr>
                        <td class="info size"><strong>Fuel SubCharges:</strong></td>
                        <td class="info size">+ 0</td>
                    </tr>
                    <tr>
                        <td class="info size"><strong>Flyer Charges:</strong></td>
                        <td class="info size">+ {{ $invoice->flyer_charges }}</td>
                    </tr>
                    <tr>
                        <td class="info size"><strong>Net Shipping Charges:</strong></td>
                        <td class="info size">{{ $net_charges = $invoice->flyer_charges + $invoice->shipping_charges }}</td>
                    </tr>
                    <tr>
                        <td class="info size"><strong>GST:</strong></td>
                        <td class="info size">+ {{ $GST = round($net_charges * 0.13) }}</td>
                    </tr>
                    <tr>
                        <td class="info size"><strong>Total Invoice Amount:</strong></td>
                        <td class="info size">{{ $total_invoice_amount = $net_charges + $GST }}</td>
                    </tr>
                </table>
            </td>
            <td class="summary">
                <table width="90%">
                    <tr>
                        <td class="info size"><strong>Total COD Amount</strong></td>
                        <td class="info size">{{ $invoice->cod_amount }}</td>
                    </tr>
                    <tr>
                        <td class="info size"><strong>Arrears:</strong></td>
                        <td class="info size">+ {{ $invoice->arrears }}</td>
                    </tr>
                    <tr>
                        <td class="info size"><strong>Advance Deductions:</strong></td>
                        <td class="info size">- {{ $invoice->deduction }}</td>
                    </tr>
                    <tr>
                        <td class="info size"><strong>Net Amount:</strong></td>
                        <td class="info size">{{ $net_amount = ($invoice->cod_amount + $invoice->arrears) - $invoice->deduction }}</td>
                    </tr>
                    <tr>
                        <td class="info size"><strong>Total Invoice Amount:</strong></td>
                        <td class="info size">- {{ $total_invoice_amount }}</td>
                    </tr>
                    <tr>
                        <td class="info size"><strong>Last Net Amount</strong></td>
                        <td class="info size">0</td>
                    </tr>
                    <tr>
                        <td class="info size"><strong>Net Payable:</strong></td>
                        <td class="info size">{{ $net_amount - $total_invoice_amount }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <br>
	<br> 

    <table class="summary" width="100%">
        <tr class="summary" class="summary">
            <th class="summary parcel">S.No</th>
            <th class="summary parcel">ParcelNo</th>
            <th class="summary parcel">Consignee</th>
            <th class="summary parcel">BookingDate</th>
            <th class="summary parcel">Origin</th>
            <th class="summary parcel">Destination</th>
            <th class="summary parcel">Weight</th>
            <th class="summary parcel">CODAmount</th>
            <th class="summary parcel">DeliveryCharges</th>
            <th class="summary parcel">Status</th>
        </tr>
        @foreach ($invoice->parcels as $key => $parcel)
            <tr class="summary">
                <th class="summary parcel">{{ $key + 1 }}</th>
                <th class="summary parcel">{{ $parcel->parcel->id }}</th>
                <th class="summary parcel">{{ $parcel->parcel->id }}</th>
                <th class="summary parcel">{{ date('Y-m-d', strtotime($parcel->parcel->created_at)) }}</th>
                <th class="summary parcel">{{ $invoice->customer->city }}</th>
                <th class="summary parcel">{{ $parcel->parcel->destination_city }}</th>
                <th class="summary parcel">{{ $parcel->parcel->weight }}</th>
                <th class="summary parcel">{{ $parcel->parcel->cod_amount }}</th>
                <th class="summary parcel">{{ $parcel->parcel->shipping_amount}}</th>
                <th class="summary parcel">{{ $parcel->parcel->status->parcel_status }}</th>
            </tr>
        @endforeach
      </table>
	  <footer>
	    <br>
		<br>
		<img src="assets/img/noc-logo-md.png" alt="Profile Picture" width="260">
		<hr>
	  </footer>

</body>
</html>