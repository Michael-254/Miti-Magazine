@extends('layouts.main')

@section('content')
<div id="slider" class="inspiro-slider slider-halfscreen dots-creative" data-height-xs="360" data-autoplay="2600" data-animate-in="fadeIn" data-animate-out="fadeOut" data-items="1" data-loop="true" data-autoplay="true">

    <div class="slide background-image" style="background-image:url('/storage/drp.JPG');">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="slide-captions text-center">

                <h2 class="text-uppercase text-medium text-light">Welcome to Miti Magazine</h2>
                <p class="lead text-light">Miti is a high-quality quarterly publication on forestry in East Africa,
                    <br /> providing specialist information in an attractive way since 2009.
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
                <div class="col-xl-3 col-md-6 col-sm-12 mt-2" data-animate="fadeInUp" data-animate-delay="0">
                    <div class="card">
                        <div class="card-content">
                            <a href="{{ url('user/read/'.$magazine->slug)}}" class="mt-2">
                                <div class="card-body">
                                    <img class="card-img-top img-fluid" src="{{asset('files/magazines/cover/'.$magazine->image)}}" alt="Card image cap">
                                    <h5 class="my-1 font-bold text-blue-600">Issue {{$magazine->issue_no}} ({{$magazine->title}})</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


<section class="bg-success text-center">
    <div class="container" data-animate="fadeInUp" data-animate-delay="0">
        <h3 class="lead text-light">Wish to View Previous Miti Magazine issues and purchase
        </h3>
        <a class="btn btn-primary" href="{{route('previous.issues')}}">View Now</a>
    </div>
</section>
@endsection