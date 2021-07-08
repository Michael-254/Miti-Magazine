@extends('layouts.main')

@section('content')
<div id="slider" class="inspiro-slider slider-halfscreen dots-creative" data-height-xs="360" data-autoplay="2600" data-animate-in="fadeIn" data-animate-out="fadeOut" data-items="1" data-loop="true" data-autoplay="true">

    <div class="slide background-image" style="background-image:url('/storage/drp.jpg');">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="slide-captions text-center">

                <h2 class="text-uppercase text-medium text-light">Welcome to Miti Magazine</h2>
                <p class="lead text-light">Miti is a high-quality quarterly on forestry in East Africa,
                    <br /> providing specialist information beautifully presented. Since 2009.
                </p>
                <a class="btn btn-primary" href="{{route('choose.plan')}}">Start your Subscription Now</a>
            </div>
        </div>
    </div>

</div>


<section>
    <div class="container">
        <div class="text-xl text-center mb-3">
            <h2 class="font-bold text-xl uppercase px-8 text-black">Recent Miti Issues</h2>
        </div>
        <div class="row">
            @foreach($recentmagazines as $magazine)
            <div class="col-lg-3" data-animate="fadeInUp" data-animate-delay="0">
                <a href="{{ url('user/read/issue_47') }}" class="mt-2">
                    <div class="bg-white h-full p-8 flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                        <div class="border rounded-md px-2 py-2">
                            <img class="object-fill h-48 w-full" src="{{asset('files/magazines/cover/'.$magazine->image)}}">
                        </div>
                        <div class="mt-4 font-bold">{{$magazine->issue_no}}</div>
                        <div class="text-center mt-2 text-gray-600 text-sm">{{$magazine->title}}</div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>


<section class="bg-success text-center">
    <div class="container" data-animate="fadeInUp" data-animate-delay="0">
        <h3 class="lead text-light">Wish to View Previous Issues and purchase each @ 250 KSH
        </h3>
        <a class="btn btn-primary" href="{{route('previous.issues')}}">View Now</a>
    </div>
</section>
@endsection