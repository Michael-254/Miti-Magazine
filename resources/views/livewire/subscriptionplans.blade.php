<div class="content-body">
    <!-- Extract to Slot -->
    <section id="description" class="card">
        <div class="card-header flex justify-between">
            <h4 class="card-title text-green-600">Manage Subscription Plans</h4>
            <button type="button" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Add New</button>
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
                                                      <i class="fa fa-trash cursor-pointer text-red-500 hover:text-red-700"></i>
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
</div>
