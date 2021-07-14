@extends('layouts.main')

@section('content')
<section>
    <div class="container">
        <div class="text-xl text-center mb-3">
            <h2 class="font-bold text-xl uppercase px-8 text-black">Previous Miti Issues (@250 KSH)</h2>
            <div class="mb-4 px-4 py-3 leading-normal text-blue-700 rounded-lg text-right" role="alert">
                <i class="fa fa-shopping-cart"></i>
                Cart ({{Cart::getContent()->count()}})
                @if(Cart::getContent()->count())
                <a href="{{route('checkout.cart')}}" class="mt-1 btn btn-success btn-sm">Check out</a>
                @endif
            </div>
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
                        @if(Cart::getContent()->where('id',$magazine->id)->count())
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product" value="{{$magazine->id}}">
                            <div class="text-center text-gray-600 text-sm mb-2">
                                <x-button class="bg-black">Remove from Cart</x-button>
                            </div>
                        </form>
                        @else
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product" value="{{$magazine->id}}">
                            <div class="text-center text-gray-600 text-sm mb-1">
                                <input name="quantity" type="number" value="1" class="text-sm sm:text-base px-2 pr-2 rounded-lg border border-gray-400 py-1 focus:outline-none focus:border-blue-400" style="width: 50px" />
                                <x-button class="bg-green-800 hover:bg-blue-600"><i class="icon-shopping-cart"></i> Add to Cart</x-button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection