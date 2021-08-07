<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Online Miti Magazine | Better Globe Forestry LTD</title>
	<style type="text/css" media="screen">
		html {
			font-family: sans-serif;
			line-height: 1.15;
			margin: 0;
		}

		body {
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
			font-weight: 400;
			line-height: 1.5;
			color: #212529;
			text-align: left;
			background-color: #fff;
			margin: 36pt;
		}

		h4 {
			margin-top: 0;
			margin-bottom: 0.5rem;
		}

		p {
			margin-top: 0;
			margin-bottom: 1rem;
		}

		strong {
			font-weight: bolder;
		}

		img {
			vertical-align: middle;
			border-style: none;
		}

		table {
			border-collapse: collapse;
		}

		th {
			text-align: inherit;
		}

		h4,
		.h4 {
			margin-bottom: 0.5rem;
			font-weight: 500;
			line-height: 1.2;
		}

		h4,
		.h4 {
			font-size: 1.5rem;
		}

		.table {
			width: 100%;
			margin-bottom: 1rem;
			color: #212529;
		}

		.table th,
		.table td {
			padding: 0.75rem;
			vertical-align: top;
			border-top: 1px solid #dee2e6;
		}

		.table thead th {
			vertical-align: bottom;
			border-bottom: 2px solid #dee2e6;
		}

		.table tbody+tbody {
			border-top: 2px solid #dee2e6;
		}

		.mt-5 {
			margin-top: 3rem !important;
		}

		.pr-0,
		.px-0 {
			padding-right: 0 !important;
		}

		.pl-0,
		.px-0 {
			padding-left: 0 !important;
		}

		.text-right {
			text-align: right !important;
		}

		.text-center {
			text-align: center !important;
		}

		.text-uppercase {
			text-transform: uppercase !important;
		}

		* {
			font-family: "DejaVu Sans";
		}

		body,
		h1,
		h2,
		h3,
		h4,
		h5,
		h6,
		table,
		th,
		tr,
		td,
		p,
		div {
			line-height: 1.1;
		}

		.party-header {
			font-size: 1.5rem;
			font-weight: 400;
		}

		.total-amount {
			font-size: 12px;
			font-weight: 700;
		}

		.border-0 {
			border: none !important;
		}
	</style>
</head>

<body>
	<!-- invoice page -->
	<section class="card">
		<div  class="card-body">
			<!-- Invoice Company Details -->
			<div class="row">
        <table style="width: 100%;">
          <tr>
            <td>
              <div class="col-sm-6 col-12 text-left pt-1">
                <div class="media pt-1">
                  <img src="{{asset('storage/logo.png')}}" width="100" height="100" alt="company logo" />
                </div>
              </div>
            </td>
            <td>
              <div class="col-sm-6 col-12 text-right">
                <div class="invoice-details mt-2">
                  <p class="text-green-800">INVOICE NO: {{ $invoice_no }}</p>
                  <p class="text-green-800">INVOICE DATE: {{ \Carbon\Carbon::parse($invoice_date)->format('d-M-Y') }}</p>
                </div>
              </div>
            </td>
          </tr>
        </table>


			</div>
			<!--/ Invoice Company Details -->

			<!-- Invoice Recipient Details -->
			<div class="row mt-2">
        <table style="width: 100%;">
          <tr>
            <td>
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
            </td>
            <td>
              <div class="col-sm-6">
                <h5 class="mb-3">From:</h5>
                <h3 class="text-dark mb-1">Better Globe Forestry</h3>
                <div>Tabere Cresecent, Kileleshwa</div>
                <div>Nairobi, Kenya</div>
                <div>823-00606</div>
                <div>Email: miti-magazine@betterglobeforestry.com</div>
                <div>Phone: +254 (0)20 3594200</div>
              </div>
            </td>
          </tr>
        </table>


			</div>
			<!--/ Invoice Recipient Details -->

			<!-- Invoice Items Details -->
			<div id="invoice-items-details" class="pt-1 invoice-items-table">
				<div class="row">
					<div class="table-responsive col-12">
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
				</div>
			</div>
			<div id="invoice-total-details" class="invoice-total-table">
				<div class="row">
					<div class="col-7 offset-5">
						<div class="table-responsive">
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
			</div>

			<!-- Invoice Footer -->
			<div id="invoice-footer" class="text-right pt-3">
				<p>www.betterglobeforestry.com.
				<p class="bank-details mb-0">
					<span class="mr-4">PIN: <strong>P051167447E</strong></span>
				</p>
			</div>
			<!--/ Invoice Footer -->

		</div>
	</section>
	<!-- invoice page end -->
</body>

</html>