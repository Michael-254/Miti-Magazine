@extends('layouts.app')

@section('content')
<div class="content-body">
    <!-- Extract to Slot -->
    <section id="description" class="card">
        <div class="card-header">
            <h4 class="card-title text-green-600">My Payments</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="card-text">

                    <div class="tab-content">
                        <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-2" :errors="$errors" />

                            <div class="card-content">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr class="text-blue-600">
                                                <th>Date Paid</th>
                                                <th>Channel Used</th>
                                                <th>Amount Paid</th>
                                                <th>Reference ID</th>
                                                <th>Invoice</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($paypalpayments as $payment)
                                            <tr>
                                                <td>{{$payment->updated_at->format('d-m-Y')}}</td>
                                                <td>Paypal</td>
                                                <td>{{$payment->amount}}</td>
                                                <td>{{$payment->reference}}</td>
                                                <td><i class="fa fa-download cursor-pointer text-green-600 hover:text-blue-700"></i></td>
                                            </tr>
                                            @endforeach
                                            @foreach($ipaypayments as $payment)
                                            <tr>
                                                <td>{{$payment->updated_at->format('d-m-Y')}}</td>
                                                <td>Ipay ({{$payment->channel}})</td>
                                                <td>{{$payment->amount}}</td>
                                                <td>{{$payment->reference}}</td>
                                                <td><i class="fa fa-download cursor-pointer text-green-600 hover:text-blue-700"></i></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="flex justify-end">
                                @if($ipaypayments->count() < $paypalpayments->count())
                                    {{$paypalpayments->links()}}
                                @else
                                    {{$ipaypayments->links()}}
                                @endif
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </section>
</div>
@endsection