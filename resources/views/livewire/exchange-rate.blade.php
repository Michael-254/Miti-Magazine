<div class="content-body">
    <!-- Extract to Slot -->
    <section id="description" class="card">
        <div class="card-header flex justify-between">
            <h4 class="card-title text-green-600">Manage Exchange rates</h4>
            <div class="flex space-x-2">
                <svg class="mt-0.5 stroke-current h-9 w-9 animate-spin text-gray-400" wire:loading="wire:loading" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="card-text">

                    <div class="tab-content">
                        <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                            <!-- Success Message -->
                            @if(session()->has('message'))
                            <div class="alert alert-success flex items-center">
                                <i class="fa fa-check mr-1"></i>
                                <p class="mb-0">
                                    {{ session()->get('message') }}
                                </p>
                            </div>
                            @endif
                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-2" :errors="$errors" />
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr class="text-blue-600">
                                                <th>#</th>
                                                <th>Main Currency</th>
                                                <th>UGX</th>
                                                <th>TSh</th>
                                                <th>KES/USD</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rates as $rate)
                                            @if($amend == $rate->id)
                                            <tr>
                                                <td scope="row">{{$rate->id}}</td>
                                                <td>{{$rate->currency}}</td>
                                                <td>
                                                    <input wire:model.defer="UGX" type="number" class="border-gray-300 form-control rounded-md" placeholder="Digital Price">
                                                </td>
                                                <td>
                                                    <input wire:model.defer="TSH" type="number" class="border-gray-300 form-control rounded-md" placeholder="Digital Price">
                                                </td>
                                                <td>
                                                    <input wire:model.defer="KSHS_USD" type="number" class="border-gray-300 form-control rounded-md" placeholder="Digital Price">
                                                </td>
                                                <td>
                                                    <div class="flex space-x-2">
                                                        <i wire:click="updaterate" class="fa fa-save cursor-pointer text-green-500 hover:text-green-700"></i>
                                                        <i wire:click="cancel" class="fa fa-window-close cursor-pointer text-yellow-500 hover:text-yellow-700"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td scope="row">{{$rate->id}}</td>
                                                <td>{{$rate->currency}}</td>
                                                <td>{{$rate->UGX}}</td>
                                                <td>{{$rate->TSH}}</td>
                                                <td>{{$rate->KSHS_USD}}</td>
                                                <td>
                                                    <div class="flex space-x-2">
                                                        <i wire:click="change({{$rate->id}})" class="fa fa-pencil-square-o cursor-pointer text-blue-500 hover:text-blue-700"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </section>


</div>