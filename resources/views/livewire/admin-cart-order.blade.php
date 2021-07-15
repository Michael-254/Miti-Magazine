<div class="content-body">
    <!-- Extract to Slot -->
    <section id="description" class="card">
        <div class="card-header flex justify-between">
            <h4 class="card-title text-green-600">Manage Cart orders</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="card-text">
                    <div class="flex items-center float-right">
                        <svg class="mr-0.5 stroke-current h-12 w-12 animate-spin text-gray-400" wire:loading="wire:loading" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <input wire:model.debounce.150ms="search" type="text" class="rounded-md form-control" id="filter-text-box" placeholder="Search....">
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-2" :errors="$errors" />
                            @include('partials/alertB')
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr class="text-blue-600">
                                                <th>#</th>
                                                <th>Customer Name</th>
                                                <th>Customer Email</th>
                                                <th>Customer Location</th>
                                                <th>Reference</th>
                                                <th>Status</th>
                                                <th>Issues Selected and Quantity</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($orders as $order)
                                            <tr>
                                                <td scope="row">{{$loop->iteration}}</td>
                                                <td>{{$order->user->name}}</td>
                                                <td>{{$order->user->email}}</td>
                                                <td>{{$order->user->myCountry->country}}</td>
                                                <td>{{$order->status}}</td>
                                                <td>{{$order->reference}}</td>
                                                <td>
                                                   @foreach($order->items as $item)
                                                  <p>Issue: {{$item->issue_no}}  Quantity: {{$item->quantity}}</p> 
                                                   @endforeach
                                                </td>
                                                <td>
                                                    <div class="flex space-x-2">
                                                        <i wire:click="Order({{$order->id}})" data-toggle="modal" data-target="#default" class="fa fa-pencil-square-o cursor-pointer text-blue-500 hover:text-blue-700"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td>
                                                    No cart Orders yet
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="flex justify-end">
                                    {{ $orders->links() }}
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </section>

    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <!-- Modal -->
                <div wire:ignore.self class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title text-xl text-green-600" id="myModalLabel1">Update Cart Order Status</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <h5 class="font-bold text-blue-600">Shipping Information</h5>
                                            @if($shipping)
                                            <div class="recipient-info my-2">
                                                <p>Apartment: {{$shipping->apartment}}</p>
                                                <p>State/City: {{$shipping->state}}, {{$shipping->city}}</p>
                                                <p>Address: {{$shipping->address}},{{$shipping->zip_code}}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="text-green-600 font-bold">Status</label>
                                    <select wire:model="status" class="form-control">
                                        <option value="">-- Update Status --</option>
                                        <option value="pending">pending</option>
                                        <option value="dispached">dispached</option>
                                        <option value="cancelled">cancelled</option>
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button wire:click.prevent="update" class="btn btn-primary mr-1 mb-1" data-dismiss="modal">Save</button>
                                <button type="reset" class="btn btn-outline-warning mr-1 mb-1" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>