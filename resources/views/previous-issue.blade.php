@extends('layouts.main')

@section('content')
<section>
    <div class="container">
        <div class="text-xl text-center mb-3">
            <h2 class="font-bold text-xl uppercase px-8 text-black">Previous Miti Issues</h2>
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
            <div class="col-lg-2" data-animate="fadeInUp" data-animate-delay="0">
                <div class="bg-white h-full p-8 flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <a href="#" class="mt-2">
                        <div class="border rounded-md px-2 py-2">
                            <img class="object-fill h-48 w-full" src="{{asset('files/magazines/cover/'.$magazine->image)}}">
                        </div>
                        <div class="mt-4 font-bold text-blue-600">Issue {{$magazine->issue_no}}</div>
                        <div class="text-center mt-2 text-gray-600 text-sm">{{$magazine->title}}</div>
                        <div class="text-center mt-2 text-gray-600 text-sm">KSH 250</div>
                    </a>
                    @if(Cart::getContent()->where('id',$magazine->id)->count())
                    <form action="{{ route('cart.remove') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product" value="{{$magazine->id}}">
                        <x-button class="mt-2 bg-black">Remove from Cart</x-button>
                    </form>
                    @else
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product" value="{{$magazine->id}}">
                        <div class="text-center mt-2 text-gray-600 text-sm">
                            <input name="quantity" type="number" value="1" class="text-sm sm:text-base px-2 pr-2 rounded-lg border border-gray-400 py-1 focus:outline-none focus:border-blue-400" style="width: 50px" />
                        </div>
                        <x-button class="mt-2 bg-green-800 hover:bg-blue-600">Add to Cart</x-button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection