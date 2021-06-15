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

        <div class="flex flex-col sm:grid lg:grid-cols-5 md:grid-cols-3 sm:-mx-2">
            <a href="{{ url('user/read/issue_47') }}" class="mt-2" data-aos="flip-right">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="https://files.magzter.com/resize/magazine/1394809325/1621316173/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 46</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </a>

            <a href="{{ url('user/read/issue_46') }}" class="mt-2" data-aos="flip-right">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="https://files.magzter.com/resize/magazine/1354588640/1622100821/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 46</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </a>

            <a href="{{ url('user/read/issue_46') }}" class="mt-2" data-aos="flip-right">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="https://files.magzter.com/resize/magazine/1343918525/1622011952/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 46</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </a>

            <a href="{{ url('user/read/issue_46') }}" class="mt-2" data-aos="flip-right">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="https://files.magzter.com/resize/magazine/1359122596/1622010544/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 46</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </a>

            <a href="{{ url('user/read/issue_47') }}" class="mt-2" data-aos="flip-right">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="https://files.magzter.com/resize/magazine/1429714855/1620997113/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 46</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </a>

            <a href="{{ url('user/read/issue_46') }}" class="mt-2" data-aos="flip-right">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="https://files.magzter.com/resize/magazine/1338193253/1621603041/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 46</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </a>

            <a href="{{ url('user/read/issue_46') }}" class="mt-2" data-aos="flip-right">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="https://files.magzter.com/resize/magazine/1430147033/1622118068/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 46</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </a>

            <a href="{{ url('user/read/issue_46') }}" class="mt-2" data-aos="flip-right">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="https://files.magzter.com/resize/magazine/1343679896/1617070061/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 46</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </a>

            <a href="{{ url('user/read/issue_46') }}" class="mt-2" data-aos="flip-right">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="https://files.magzter.com/resize/magazine/1412680414/1623066486/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 46</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </a>

            <a href="{{ url('user/read/issue_46') }}" class="mt-2" data-aos="flip-right">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="https://files.magzter.com/resize/magazine/1423230088/1619552515/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 46</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </a>

        </div>



    </div>

</main>

@endsection