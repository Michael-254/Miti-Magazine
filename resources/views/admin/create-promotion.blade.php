@extends('layouts.app')

@section('content')
<div class="content-body">
    <!-- Extract to Slot -->
    <section id="description" class="card">
        <div class="card-header">
            <h4 class="card-title text-green-600">Offer Magazine For Promotion</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="card-text">

                    <div class="tab-content">
                        <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-2" :errors="$errors" />
                            @if(session()->has('message'))
                            <div class="alert alert-success flex items-center">
                                <i class="fa fa-check mr-1"></i>
                                <p class="mb-0">
                                    {{ session()->get('message') }}
                                </p>
                            </div>
                            @endif

                            <div class="row">
                                <div class="max-w-7xl mx-auto">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <form class="form form-vertical" action="{{route('update.promotion')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('patch')
                                                    <div class="form-body">
                                                        <div class="row">

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="font-bold text-green-600">Issue_no</label>
                                                                    <div class="mt-1">
                                                                        <select name="magazine" class="rounded-md border-gray-400 form-control" required>
                                                                            <option value="">-- Select Magazine --</option>
                                                                            @foreach ($magazines as $magazine)
                                                                            @if ($magazine->type == 'payable')
                                                                            <option value="{{$magazine->id}}">Issue No:{{$magazine->issue_no}}</option>
                                                                            @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 mt-1">
                                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                                                <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                                <div class="table-responsive">
                                                    <table class="table table-hover mb-0">
                                                        <thead>
                                                            <tr class="text-blue-600">
                                                                <th>#</th>
                                                                <th>Issue No</th>
                                                                <th>Title</th>
                                                                <th>Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($magazines as $magazine)
                                                            @if($magazine->type == 'promotional')
                                                            <tr>
                                                                <td scope="row">{{$magazine->id}}</td>
                                                                <td>{{$magazine->issue_no}}</td>
                                                                <td>{{$magazine->title}}</td>
                                                                <td>{{$magazine->file}}</td>
                                                                <td>
                                                                    <div class="flex space-x-2">
                                                                        <a href="{{route('destroy.promotion',$magazine->id)}}">
                                                                          <i class="fa fa-trash cursor-pointer text-red-500 hover:text-red-700"></i>
                                                                        </a>
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
                            <!-- users edit account form ends -->
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </section>
</div>

@endsection