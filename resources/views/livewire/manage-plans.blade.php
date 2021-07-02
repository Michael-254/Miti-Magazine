<div class="content-body">
    <!-- Extract to Slot -->
    <section id="description" class="card">
        <div class="card-header flex justify-between">
            <h4 class="card-title text-green-600">Manage Subscription Plans</h4>
            <div class="flex space-x-2">
                <svg class="mt-0.5 stroke-current h-9 w-9 animate-spin text-gray-400" wire:loading="wire:loading" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <button type="button" class="btn btn-primary mr-1 mb-1 waves-effect waves-light" data-toggle="modal" data-target="#default">Add New</button>
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
                                                <th>Location</th>
                                                <th>Copies</th>
                                                <th>Digital</th>
                                                <th>Digital & Printed</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($plans as $plan)
                                            @if($amend == $plan->id)
                                            <tr>
                                                <td scope="row">{{$plan->id}}</td>
                                                <td>
                                                    <select wire:model="locationE" class="form-control">
                                                        <option value="Kenya">Kenya</option>
                                                        <option value="Uganda">Uganda</option>
                                                        <option value="Tanzania">Tanzania</option>
                                                        <option value="Rest of World">Rest of World</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select wire:model="quantityE" class="form-control">
                                                        <option value="">-- Subscription Copies --</option>
                                                        <option value="1">Single</option>
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input wire:model.defer="digitalE" type="number" class="border-gray-300 form-control rounded-md" placeholder="Digital Price">
                                                </td>
                                                <td>
                                                    <input wire:model.defer="combinedE" type="number" class="border-gray-300 form-control rounded-md" placeholder="Digital Price">
                                                </td>
                                                <td>
                                                    <div class="flex space-x-2">
                                                        <i wire:click="updatePlan" class="fa fa-save cursor-pointer text-green-500 hover:text-green-700"></i>
                                                        <i wire:click="cancel" class="fa fa-window-close cursor-pointer text-yellow-500 hover:text-yellow-700"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td scope="row">{{$plan->id}}</td>
                                                <td>{{$plan->location}}</td>
                                                <td>{{$plan->quantity}}</td>
                                                <td><span class="font-bold text-sm mr-0.5">{{$plan->currency()}}</span>{{$plan->amounts->digital}}</td>
                                                <td><span class="font-bold text-sm mr-0.5">{{$plan->currency()}}</span>{{$plan->amounts->combined}}</td>
                                                <td>
                                                    <div class="flex space-x-2">
                                                        <i wire:click="change({{$plan->id}})" class="fa fa-pencil-square-o cursor-pointer text-blue-500 hover:text-blue-700"></i>
                                                        <i onclick="confirm('Are you Sure?') || event.stopImmediatePropagation()" wire:click="destroy({{$plan->id}})" class="fa fa-trash cursor-pointer text-red-500 hover:text-red-700"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="flex justify-end">
                                    {{ $plans->links() }}
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
                                <h4 class="modal-title text-xl text-green-600" id="myModalLabel1">Subscription Plan</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label class="text-green-600 font-bold">Location</label>
                                    <select wire:model="location" class="form-control">
                                        <option value="">-- Location --</option>
                                        <option value="Kenya">Kenya</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Tanzania">Tanzania</option>
                                        <option value="Rest of World">Rest of World</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="text-green-600 font-bold">Number of Subscription copies</label>
                                    <select wire:model="quantity" class="form-control">
                                        <option value="">-- Subscription Copies --</option>
                                        <option value="1">Single</option>
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="text-green-600 font-bold">Digital Price</label>
                                    <input wire:model.defer="digital" type="number" class="border-gray-300 form-control rounded-md" placeholder="Digital Price">
                                </div>

                                <div class="form-group">
                                    <label class="text-green-600 font-bold">Digital and Prited Price</label>
                                    <input wire:model.defer="combined" type="number" class="border-gray-300 form-control rounded-md" placeholder="Digital and Prited Price">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button wire:click.prevent="save" class="btn btn-primary mr-1 mb-1" data-dismiss="modal">Save</button>
                                <button type="reset" class="btn btn-outline-warning mr-1 mb-1" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>