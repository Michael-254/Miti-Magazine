@extends('layouts.main')

@section('content')
<section>
    <div class="container">
        <div class="text-xl text-center mb-3">
            <h2 class="font-bold text-xl uppercase px-8 text-black">Previous MITI Magazine single issues for sale</h2>
            @livewire('cart-contain')
        </div>
        @if(session()->has('message'))
        <div class="px-6 text-center">
            <p class="text-green-500 font-bold">
                {{ session()->get('message') }}
            </p>
        </div>
        @endif
        <div class="row">
            @foreach($previousmagazines as $magazine)
            <div class="col-xl-2 col-md-6 col-sm-12 mt-2" data-animate="fadeInUp" data-animate-delay="0">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <img class="card-img-top img-fluid" src="{{asset('files/magazines/cover/'.$magazine->image)}}" alt="Card image cap">
                            <h5 class="font-bold text-blue-600">Issue {{$magazine->issue_no}} ({{$magazine->title}})</h5>
                        </div>
                        @livewire('cart-item',['magazine' => $magazine])
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection