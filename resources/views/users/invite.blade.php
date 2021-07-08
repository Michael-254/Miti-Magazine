@extends('layouts.app')

@section('content')

<div class="content-body">
    <!-- account setting page start -->
    <section id="page-account-settings">
        <div class="row">
            <!-- left menu section -->
            <div class="col-md-3 mb-2 mb-md-0">
                <ul class="nav nav-pills flex-column mt-md-0 mt-1">
                    <li class="nav-item">
                        <a class="nav-link d-flex py-75 active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                            <i class="fa fa-users mr-50 font-medium-3"></i>
                            My Invited Members
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex py-75" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                            <i class="fa fa-user mr-50 font-medium-3"></i>
                            Invite member
                        </a>
                    </li>
                </ul>
            </div>
            <!-- right content section -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                                    <div class="media">
                                        <h4 class="card-title text-green-600">My Invited Members</h4>
                                    </div>
                                    <!-- Validation Errors -->
                                    <x-auth-validation-errors class="mb-2" :errors="$errors" />
                                    <!-- Success Message -->
                                    @include('partials.alertB')
                                    <hr>
                                    <form novalidate>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-hover mb-0">
                                                        <thead>
                                                            <tr class="text-blue-600">
                                                                <th>Date Invited</th>
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>Subscription Plan Details</th>
                                                                <th>Action</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($members as $member)
                                                            <tr>
                                                                <td>{{$member->members->created_at->format('d-m-Y')}}</td>
                                                                <td>{{$member->members->name}}</td>
                                                                <td>{{$member->members->email}}</td>
                                                                <td>{{$member->subscriptionSize->type}}
                                                                {{App\Models\SubscriptionPlan::findOrFail($member->subscriptionSize->subscription_plan_id)->quantity}} Copies
                                                                </td>
                                                                <td>
                                                                    <a href="{{route('member.destroy',$member)}}">
                                                                        <i class="fa fa-trash cursor-pointer text-red-600 hover:text-red-800"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="flex justify-end">
                                                    {{$members->links()}}
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade " id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                    <form action="{{route('member.store')}}" method="POST" novalidate>
                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-old-password">Name</label>
                                                        <input type="text" name="name" value="{{old('name')}}" class="form-control rounded-md border-gray-300" required placeholder="Member Names">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-old-password">Email</label>
                                                        <input type="email" name="email" value="{{old('email')}}" class="form-control rounded-md border-gray-300" required placeholder="Member Email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label for="account-old-password">Plan you wish to Invite Members</label>
                                                        <select name="plan" class="rounded-md border-gray-400 form-control" id="users-language-select2">
                                                            <option value="">-- Select Plan --</option>
                                                            @foreach($userSubscriptions as $sub)
                                                            <option value="{{$sub->id}}">{{$sub->type}} 
                                                                {{App\Models\SubscriptionPlan::findOrFail($sub->subscription_plan_id)->quantity}} Copies
                                                            </option>
                                                            @endforeach                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Send Invite</button>
                                                <button type="reset" class="btn btn-outline-warning">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- account setting page end -->
    @endsection