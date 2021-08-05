<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<title>Online Miti Magazine | Better Globe Forestry LTD</title>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
    background-color: #000
}

.padding {
    padding: 2rem !important
}

.card {
    margin-bottom: 30px;
    border: none;
    -webkit-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
    -moz-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
    box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22)
}

.card-header {
    background-color: #fff;
    border-bottom: 1px solid #e6e6f2
}

h3 {
    font-size: 20px
}

h5 {
    font-size: 15px;
    line-height: 26px;
    color: #3d405c;
    margin: 0px 0px 15px 0px;
    font-family: 'Circular Std Medium'
}

.text-dark {
    color: #3d405c !important
}
	</style>
</head>
<body>
	<div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
		<div class="card">
			<div class="card-header p-4">
				<img src="{{asset('storage/logo.png')}}" alt="company logo" style="border-radius:10px; width:100%;" />
				<div class="float-right">
					<h3 class="mb-0">Invoice {{ $invoice_no }}</h3>
					Date: {{ \Carbon\Carbon::parse($invoice_date)->format('d-M-Y') }}
				</div>
			</div>
			<div class="card-body">
				<div class="row mb-4">
					<div class="col-sm-6">
						<h5 class="mb-3">From:</h5>
						<h3 class="text-dark mb-1">Better Globe Forestry</h3>
						<div>Tabere Cresecent, Kileleshwa</div>
						<div>Nairobi, Kenya</div>
						<div>823-00606</div>
						<div>Email: miti-magazine@betterglobeforestry.com</div>
						<div>Phone: +254 (0)20 3594200</div>
					</div>
					<div class="col-sm-6 ">
						@php
						$Owner = \App\Models\User::find($user['id']);
						@endphp
						<h5 class="mb-3">To:</h5>
						<h3 class="text-dark mb-1">{{ $user['name'] }}</h3>
						<div>{{ $Owner->shippingInfo->address  }}</div>
						<div>{{ $Owner->shippingInfo->city.", ".$Owner->shippingInfo->state }}</div>
						<div>{{ $Owner->shippingInfo->zip_code }}</div>
						<div>Email: {{ $user['email'] }}</div>
						<div>Phone: {{ $user['phone_no'] }}</div>
					</div>
				</div>
				<div class="table-responsive-sm">
					<table class="table table-striped">
						<thead>
							@if($transaction == "Subscription")
                                    <tr>
                                        <th class="right">ITEM DESCRIPTION</th>
                                        <th class="center">QUANTITY TO RECEIVE PER ISSUE</th>
                                        <th class="right">AMOUNT</th>
                                    </tr>
                                    @endif
                                    @if($transaction == "Cart Order")
                                    <tr>
                                        <th class="right">ITEM DESCRIPTION</th>
                                        <th class="center">QUANTITY</th>
                                        <th class="center">UNIT PRICE</th>
                                        <th class="right">SUB-TOTAL</th>
                                    </tr>
                                    @endif
						</thead>
						<tbody>
							@if($transaction == "Subscription")
							<tr>
								<td class="left strong">{{ "From issue: ".$items[0]['issue']." to issue: ".$items[count($items)-1]['issue'] }}</td>
								<td class="center">{{ $items[0]['quantity'] }}</td>
								<td class="right">{{ $items[0]['amount'] * 4 }}</td>
							</tr>
							@endif
							@if($transaction == "Cart Order")
							@foreach($items as $item)
							<tr>
								<td class="left strong">{{ $item['issue'] }}</td>
								<td class="center">{{ $item['quantity'] }}</td>
								<td class="center">{{ $currency." ".$item['amount'] }}</td>
								<td class="right">{{ $item['quantity'] * $item['amount'] }}</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
				<div class="row">
					<div class="col-lg-4 col-sm-5">
					</div>
					<div class="col-lg-4 col-sm-5 ml-auto">
						<table class="table table-clear">
							<tbody>
								@if($transaction == "Subscription")
									<tr>
										<td class="left">
											<strong class="text-dark">Subtotal</strong>
										</td>
										<td class="right">{{ $currency." ".($items[0]['amount'] * 4) }}</td>
									</tr>
									<tr>
										<td class="left">
											<strong class="text-dark">Discount</strong>
										</td>
										<td class="right">{{ $currency." ".$discount }}</td>
									</tr>
									<tr>
										<td class="left">
											<strong class="text-dark">Total</strong>
										</td>
										<td class="right">
											<strong class="text-dark">{{ $currency." ".(($items[0]['amount'] * 4) - $discount) }}</strong>
										</td>
									</tr>
								@else
									<tr>
										<td class="left">
											<strong class="text-dark">Subtotal</strong>
										</td>
										<td class="right">{{ $currency." ".(($items[0]['amount'] * count($items) ) - $discount) }}</td>
									</tr>
									<tr>
										<td class="left">
											<strong class="text-dark">Discount</strong>
										</td>
										<td class="right">{{ $currency." ".$discount }}</td>
									</tr>
									<tr>
										<td class="left">
											<strong class="text-dark">Total</strong>
										</td>
										<td class="right">
											<strong class="text-dark">{{ $currency." ".(($items[0]['amount'] * count($items) ))  }}</strong>
										</td>
									</tr>
							   @endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="card-footer bg-white">
				<p class="mb-0">betterglobeforestry.com, PIN: P051167447E</p>
			</div>
		</div>
	</div>
</body>
</html>