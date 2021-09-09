@extends('layouts.app')

@section('content')
<div class="content-body">
    <!-- Extract to Slot -->
    <section id="description" class="card">
        <div class="card-header">
            <h4 class="card-title text-green-600">Upload Magazine</h4>
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
                                                <form class="form form-vertical" action="{{route('magazine.upload')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-body">
                                                        <div class="row">

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="font-bold text-green-600">Issue_no</label>
                                                                    <div>
                                                                        <input type="number" name="issue_no" value="{{old('issue_no')}}" class="rounded-md border-gray-400 form-control" placeholder="Issue number">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="font-bold text-green-600">Item Code</label>
                                                                    <div>
                                                                        <input type="text" name="item_code" value="{{old('item_code')}}" class="rounded-md border-gray-400 form-control" placeholder="Item Code">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="font-bold text-green-600">Quanity in Stock</label>
                                                                    <div>
                                                                        <input type="text" name="inventory" value="{{old('inventory')}}" class="rounded-md border-gray-400 form-control" placeholder="Quantity">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="font-bold text-green-600">Title</label>
                                                                    <div>
                                                                        <input type="text" name="title" value="{{old('title')}}" class="rounded-md border-gray-400 form-control" placeholder="Title of magazine">
                                                                        <div class="form-control-position">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="media-body mt-75">
                                                                <div class="col-12">
                                                                    <label class="font-bold text-green-600">Magazine</label>
                                                                    <input type="file" name="file" accept="application/pdf" class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer">
                                                                </div>
                                                                <p class="text-muted ml-75 mt-50"><small>Allowed PDF.</small></p>
                                                            </div>

                                                            <div class="media-body mt-75">
                                                                <div class="col-12">
                                                                    <label class="font-bold text-green-600">Cover Image</label>
                                                                    <input type="file" name="image" accept="image/*" class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer">
                                                                </div>
                                                                <p class="text-muted ml-75 mt-50"><small>Allowed JPG, GIF or PNG.</small></p>
                                                            </div>

                                                            <div class="col-12 mt-2">
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