@extends('layouts.app')

@section('content')
<!-- BEGIN: Content-->
<div class="content-body">
    <!-- invoice page -->
    <section class="card invoice-page">
        <div id="invoice-template" class="card-body">
            <!-- Invoice Recipient Details -->
            <div id="invoice-customer-details" class="row pt-2">
                <div class="col-sm-6 col-12 text-left">
                    <h4 class="card-title text-green-600">Customers Information</h4>
                    <div class="recipient-info my-2">
                        <p>Name: {{$customer->name}}</p>
                        <p>Company: {{$customer->company}}</p>
                        <p>Apartment: {{$customer->shippingInfo->apartment ?? ''}}</p>
                        <p>State/City: {{$customer->shippingInfo->state ?? ''}}, {{$customer->shippingInfo->city ?? ''}}</p>
                        <p>Address: {{$customer->shippingInfo->address ?? ''}},{{$customer->shippingInfo->zip_code ?? ''}}</p>
                    </div>
                    <div class="recipient-contact pb-2">
                        <p>
                            <i class="feather icon-mail"></i>
                            {{$customer->email}}
                        </p>
                        <p>
                            <i class="feather icon-phone"></i>
                            {{$customer->phone_no}}
                        </p>
                    </div>
                </div>
            </div>
            <!--/ Invoice Recipient Details -->
            <div id="invoice-items-details" class="pt-1 invoice-items-table">
                <div class="row mx-auto items-center">
                    <div class="px-2">
                        <h4 class="card-title text-green-600">Customer Subscriptions</h4>
                    </div>
                    <div class="table-responsive col-12">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Subscription Name</th>
                                    <th>Date purchased</th>
                                    <th>Quantity received per Issue</th>
                                    <th>Selected Issues</th>
                                    <th>Members Invited</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->subscriptions as $sub)
                                @if($sub->status == 'paid')
                                <tr>
                                    <td>{{$sub->type}}</td>
                                    <td>{{$sub->updated_at->format('d-m-Y')}}</td>
                                    <td>{{$sub->quantity}}</td>
                                    <td>
                                        @foreach($sub->SubIssues as $issue)
                                        {{$issue->issue_no}}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($customer->myTeam as $team)
                                        @if($sub->id == $team->subscription_id)
                                        <div class="mt-0.5">
                                            <p>{{$team->members->name}}</p>
                                        </div>
                                        @endif
                                        @endforeach
                                    </td>
                                </tr>
                                @endif
                                @empty
                                <tr>
                                    <td>
                                        Customer has no active subscription
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Invoice Items Details -->

        </div>
    </section>
    <!-- invoice page end -->

</div>

<!-- END: Content-->
@endsection