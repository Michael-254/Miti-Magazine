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