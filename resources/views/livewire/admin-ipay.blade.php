<div class="content-body">
    <!-- Extract to Slot -->
    <section id="description" class="card">
        <div class="card-header">
            <h4 class="card-title text-green-600">Ipay Payments</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="card-text">

                    <div class="flex items-center float-right">
                        <svg class="mr-0.5 stroke-current h-12 w-12 animate-spin text-gray-400" wire:loading="wire:loading"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                            <input wire:model.debounce.150ms="search" type="text" class="rounded-md form-control" id="filter-text-box" placeholder="Search....">
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-2" :errors="$errors" />

                            <div class="card-content">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr class="text-blue-600">
                                                <th>#</th>
                                                <th>Customer Name</th>
                                                <th>Customer Location</th>
                                                <th>Customer Company</th>
                                                <th>Customer Contacts</th>
                                                <th>Channel Used</th>
                                                <th>Amount Paid</th>
                                                <th>Reference ID</th>
                                                <th>Invoice</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($payments as $payment)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$payment->user->name}}</td>
                                                <td>{{App\Models\Country::find($payment->user->country)->country}}</td>
                                                <td>{{$payment->user->company}}</td>
                                                <td>{{$payment->user->phone_no}}</td>
                                                <td>{{$payment->channel}}</td>
                                                <td>{{$payment->amount}}</td>
                                                <td>{{$payment->reference}}</td>
                                                <td><i class="fa fa-download cursor-pointer text-green-600 hover:text-blue-700"></i></td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td>
                                                    No payment yet
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="flex justify-end">
                                    {{$payments->links()}}
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </section>
</div>