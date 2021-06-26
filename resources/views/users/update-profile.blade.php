@extends('layouts.app')

@section('content')
<div class="content-body">
    <!-- Extract to Slot -->
    <section id="description" class="card">
        <div class="card-header">
            <h4 class="card-title text-green-600">Personal Information</h4>
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
                            @if(!auth()->user()->hasVerifiedEmail())
                            <div class="col-12">
                                <div class="alert alert-warning alert-dismissible mb-2" role="alert">
                                    <p class="mb-0 text-green-600">
                                        Your email is not confirmed. Please check your inbox.
                                    </p>
                                    <form method="POST" action="{{ route('verification.send') }}">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-800">Resend confirmation</button>
                                    </form>
                                </div>
                            </div>
                            @endif
                            <!-- users edit account form start -->
                            <form action="{{route('profile.update',auth()->user())}}" method="POST">
                                @csrf
                                @method('patch')

                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control" placeholder="Username" value="{{auth()->user()->name}}" required data-validation-required-message="This username field is required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>E-mail <a href="{{route('change.password')}}" class="font-bold text-blue-500 hover:text-blue-700 ml-5">Change password</a></label>
                                                <input type="email" name="email" class="form-control" value="{{auth()->user()->email}}" disabled>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12 col-sm-6">

                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Gender</label>
                                                <select name="gender" class="form-control" id="users-language-select2">
                                                    <option value="">Select Gender</option>
                                                    <option value="1" @if (auth()->user()->gender == 1) selected @endif>Male</option>
                                                    <option value="2" @if (auth()->user()->gender == 2) selected @endif>Female</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Company</label>
                                            <input type="text" name="company" class="form-control" value="{{auth()->user()->company}}" placeholder="Company name">
                                        </div>

                                    </div>

                                    <div class="col-12 col-sm-6">

                                        <div class="form-group">
                                            <label>Country</label>
                                            <select name="country" class="select2 form-control">
                                                @foreach($countries as $country)
                                                <option value="{{$country->id}}" @if (auth()->user()->country == $country->id) selected @endif>{{$country->country}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" name="city" class="form-control" value="{{auth()->user()->shippingInfo->city}}" placeholder="City">
                                        </div>

                                        <div class="form-group">
                                            <label>State</label>
                                            <input type="text" name="state" class="form-control" value="{{auth()->user()->shippingInfo->state}}" placeholder="State">
                                        </div>

                                    </div>

                                    <div class="col-12 col-sm-6">

                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control" value="{{auth()->user()->shippingInfo->address}}" placeholder="Address">
                                        </div>

                                        <div class="form-group">
                                            <label>Apartment</label>
                                            <input type="text" name="apartment" class="form-control" value="{{auth()->user()->shippingInfo->apartment}}" placeholder="Apartment">
                                        </div>

                                        <div class="form-group">
                                            <label>Zip Code</label>
                                            <input type="text" name="zip_code" class="form-control" value="{{auth()->user()->shippingInfo->zip_code}}" placeholder="Zip code">
                                        </div>

                                    </div>


                                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                        <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save
                                            Changes</button>
                                        <button type="reset" class="btn btn-outline-warning">Reset</button>
                                    </div>
                                </div>
                            </form>
                            <!-- users edit account form ends -->
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </section>
</div>

@endsection