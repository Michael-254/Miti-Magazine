@extends('layouts.app')

@section('content')

<!-- Nav Filled Starts -->
<section id="nav-filled">
    <div class="row">
        <div class="col-sm-12">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title text-green-600">My Orders</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab-fill" data-toggle="tab" href="#home-fill" role="tab" aria-controls="home-fill" aria-selected="true">My Subscription Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab-fill" data-toggle="tab" href="#profile-fill" role="tab" aria-controls="profile-fill" aria-selected="false">My Cart Orders</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content pt-1">
                            <div class="tab-pane active" id="home-fill" role="tabpanel" aria-labelledby="home-tab-fill">
                                <!-- DataTable starts -->
                                <div class="table-responsive">
                                    <table class="table data-list-view">
                                        <thead>
                                            <tr class="text-blue-600">
                                                <th>#</th>
                                                <th>Order Date</th>
                                                <th>Reference</th>
                                                <th>Issues Selected and Status</th>
                                                <th>Quantity per Issue</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($Suborders as $order)
                                            <tr>
                                                <td scope="row">{{$loop->iteration}}</td>
                                                <td>{{$order->updated_at->format('d-m-Y')}}</td>
                                                <td>{{$order->reference}}</td>
                                                <td>
                                                    @if($order->status == 'failed')
                                                    @foreach($order->selectedIssue as $issue)
                                                    <p class="badge rounded-pill rounded-md bg-red-600">{{$issue->issue_no}} {{$order->status}}</p>
                                                    @endforeach
                                                    @else
                                                    @foreach($order->selectedIssue as $issue)
                                                    @php
                                                    if($issue->status == 'dispached') { $color="bg-primary" ; }
                                                    elseif($issue->status == 'pending') { $color="bg-blue-600" ; }
                                                    else{ $color="bg-red-600" ; }
                                                    @endphp
                                                    <p class="badge rounded-pill rounded-md {{$color}}">{{$issue->issue_no}} {{$issue->status}}</p>
                                                    @endforeach
                                                    @endif
                                                </td>
                                                <td>{{$order->subPlan->quantity}}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td>
                                                    No Orders yet
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- DataTable ends -->
                            </div>
                            <div class="tab-pane" id="profile-fill" role="tabpanel" aria-labelledby="profile-tab-fill">
                                <div class="table-responsive">
                                    <table class="table data-list-view">
                                        <thead>
                                            <tr class="text-blue-600">
                                                <th>#</th>
                                                <th>Order Date</th>
                                                <th>Reference</th>
                                                <th>Issues and Quantity</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($Cartorders as $order)
                                            <tr>
                                                <td scope="row">{{$loop->iteration}}</td>
                                                <td>{{$order->created_at->format('d-m-Y')}}</td>
                                                <td>{{$order->reference}}</td>
                                                <td>
                                                    @foreach($order->items as $item)
                                                    <p>Issue: {{$item->issue_no}} Quantity: {{$item->quantity}}</p>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @php
                                                    if($order->status == 'dispached') { $color="bg-primary" ; }
                                                    elseif($order->status == 'verified') { $color="bg-blue-600" ; }
                                                    else{ $color="bg-red-600" ; }
                                                    @endphp
                                                    <p class="badge rounded-pill rounded-md {{$color}} px-2">
                                                        {{$order->status}}
                                                    </p>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td>
                                                    No Orders yet
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Nav Filled Ends -->

@endsection