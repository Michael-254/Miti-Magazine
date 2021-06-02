<div class="content-body">
    <!-- Extract to Slot -->
    <section id="description" class="card">
        <div class="card-header flex justify-between">
            <h4 class="card-title text-green-600">Manage Subscription Plans</h4>
            <button type="button" class="btn btn-primary mr-1 mb-1 waves-effect waves-light" data-toggle="modal" data-target="#default">Add New</button>
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
                                                <th>Printed</th>
                                                <th>Digital & Printed</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($plans as $plan)
                                            <tr>
                                                <td scope="row">{{$plan->id}}</td>
                                                <td>{{$plan->location}}</td>
                                                <td>{{$plan->quantity}}</td>
                                                <td><span class="font-bold text-sm mr-0.5">{{$plan->currency()}}</span>{{$plan->amounts->digital}}</td>
                                                <td><span class="font-bold text-sm mr-0.5">{{$plan->currency()}}</span>{{$plan->amounts->printed}}</td>
                                                <td><span class="font-bold text-sm mr-0.5">{{$plan->currency()}}</span>{{$plan->amounts->combined}}</td>
                                                <td>
                                                    <div class="flex space-x-2">
                                                        <i class="fa fa-pencil-square-o cursor-pointer text-blue-500 hover:text-blue-700"></i>
                                                        <i onclick="confirm('Are you Sure?') || event.stopImmediatePropagation()" wire:click="destroy({{$plan->id}})" class="fa fa-trash cursor-pointer text-red-500 hover:text-red-700"></i>
                                                    </div>
                                                </td>
                                            </tr>
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
                                    <label class="text-green-600 font-bold">Printed Price</label>
                                    <input wire:model.defer="printed" type="number" class="border-gray-300 form-control rounded-md" placeholder="Printed Price">
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