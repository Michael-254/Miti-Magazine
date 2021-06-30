@extends('layouts.app')

@section('styles')
<style>
    #page-wrapper {
        background-color: #222;
        height: 100% !important
    }

    .page-header {
        color: #ddd;
    }
</style>
@endsection

@section('breadcrumb')
<div class="page-header breadcumb-sticky">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Gallery</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('file-manager') }}">Gallery</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <!-- Success Message -->
        @if(session()->has('message'))
        <div class="alert alert-success flex items-center">
            <i class="fa fa-check mr-1"></i>
            <p class="mb-0">
                {{ session()->get('message') }}
            </p>
        </div>
        @endif
        <div class="card user-profile-list">
            <div class="card-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="{!! url('elfinder') !!}"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection