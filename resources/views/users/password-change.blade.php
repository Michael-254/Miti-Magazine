@extends('layouts.app')

@section('content')
<div class="content-body">
    <!-- Extract to Slot -->
    <section id="description" class="card">
        <div class="card-header">
            <h4 class="card-title text-green-600">Change Password</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="card-text">

                    <div class="tab-content">
                        <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-2" :errors="$errors" />

                            <div class="row">
                                <div class="max-w-6xl mx-auto">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <form class="form form-vertical" action="{{route('update.password')}}" method="POST">
                                                    @csrf
                                                    <div class="form-body">
                                                        <div class="row">

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="password-icon">Current Password</label>
                                                                    <div class="position-relative has-icon-left">
                                                                        <input type="password" name="current_password" class="rounded-md border-gray-400 form-control" placeholder="Current Password">
                                                                        <div class="form-control-position">
                                                                            <i class="feather icon-lock"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="password-icon">New Password</label>
                                                                    <div class="position-relative has-icon-left">
                                                                        <input type="password" name="password" class="rounded-md border-gray-400 form-control" placeholder="New Password">
                                                                        <div class="form-control-position">
                                                                            <i class="feather icon-lock"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="password-icon">Confirm Password</label>
                                                                    <div class="position-relative has-icon-left">
                                                                        <input type="password" name="password_confirmation" class="rounded-md border-gray-400 form-control" placeholder="Confirm Password">
                                                                        <div class="form-control-position">
                                                                            <i class="feather icon-lock"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                                                <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- users edit account form ends -->
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </section>
</div>

@endsection