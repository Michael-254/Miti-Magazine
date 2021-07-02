@extends('layouts.main')

@section('content')

<div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 75vh;">
    <div class="absolute top-0 w-full h-full bg-center bg-cover" style="background-image: url(/storage/drp.jpg);">
        <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
    </div>
    <div class="container relative mx-auto" data-aos="fade-down">
        <div class="items-center flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4 mt-16 ml-auto mr-auto text-center">
                <div>
                    <h1 class="text-white font-semibold text-2xl md:text-5xl">Welcome to Miti Magazine</h1>
                    <h4 class="mt-4 text-sm md:text-2xl md:font-semibold text-white">Miti is a high-quality quarterly on forestry in East Africa, providing specialist information beautifully presented. Since 2009.</h4>
                </div>
                <div class="mt-5">
                    <ul class="text-white text-sm mb-12 md:font-semibold md:text-xl">
                        <li>A subscription is for 1 year only, meaning 4 issues</li>
                    </ul>
                    <a href="{{route('choose.plan')}}" style="padding: 15px 81px 13px;border-radius: 4px;font: 500 15px / 16px hind;color: black;background-color: rgb(34,139,34);justify-content: center;text-align: center;cursor: pointer;text-decoration: none;outline: none;border: none;width: 280px;">SUBSCRIBE</a>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="my-4 flex flex-col px-10 p-3 shadow-md">
    <section class="text-xl uppercase font-bold px-1 mb-2 text-black">
        About our Subscriptions
    </section>
    <section class="flex items-center font-normal text-gray-500 text-md mt-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-sm md:text-lg leading-relaxed ml-1">
            Your subscription Plan will automatically renew after one year
        </p>
    </section>
    <section class="flex items-center font-normal text-md text-gray-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-sm md:text-lg leading-relaxed ml-1">
            For more than 10 copies kindly contact us through mail <x-nav-link class="text-blue-500 font-bold" href="#contact-info">Contact Information</x-nav-link>
        </p>
    </section>
</div>

<main class="my-8 w-full flex flex-col">

    <div class="mx-4">
        <h2 class="mt-1 font-bold text-xl uppercase px-8 text-black">Recent Miti Issues</h2>

        <div class="flex flex-col sm:grid lg:grid-cols-4 md:grid-cols-3 sm:-mx-2">
            @foreach($recentmagazines as $magazine)
            <a href="{{ url('user/read/issue_47') }}" class="mt-2" data-aos="flip-right">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="{{asset('files/magazines/cover/'.$magazine->image)}}">
                    </div>
                    <div class="mt-4 font-bold">{{$magazine->issue_no}}</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">{{$magazine->title}}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

</main>

<div class="my-8 w-full flex flex-col" x-data="{animate: false}">
    <div class="flex items-center font-bold p-3 px-8 cursor-pointer" @click="animate = (animate) ? false : true">
        <h2 class="mt-1 font-bold text-xl uppercase px-8 text-blue-700">View Previous Issues</h4>
        <svg class="fill-current h-6 w-6 mt-1 transform transition-transform duration-500" viewBox="0 0 20 20">
            <path d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10"></path>
        </svg>
    </div>
    <div class="flex flex-col py-3 sm:grid lg:grid-cols-4 md:grid-cols-3 sm:-mx-2" x-show="animate" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
        @foreach($previousmagazines as $magazine)
        <a href="{{ url('user/read/issue_47') }}" class="mt-2">
            <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                <div class="border rounded-md px-2 py-2">
                    <img class="object-fill h-48 w-full" src="{{asset('files/magazines/cover/'.$magazine->image)}}">
                </div>
                <div class="mt-4 font-bold">{{$magazine->issue_no}}</div>
                <div class="text-center mt-2 text-gray-600 text-sm">{{$magazine->title}}</div>
            </div>
        </a>
        @endforeach
    </div>
</div>

@endsection