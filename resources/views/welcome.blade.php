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
<main class="my-8 w-full flex flex-col items-center">

    <div class="max-w-6xl mx-4 js-show-on-scroll">
        <h2 class="mt-1 pb-1 font-bold text-xl text-green-500 border-b border-green-600">Recent Miti Issues</h2>

        <div class="flex flex-col sm:grid sm:grid-cols-3 sm:-mx-2">
            <a href="{{ url('user/read/issue_47') }}" class="mt-4" data-aos="flip-right">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="https://files.magzter.com/resize/magazine/1394809325/1621316173/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 46</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </a>

            <a href="{{ url('user/read/issue_46') }}" class="mt-4">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="https://files.magzter.com/resize/magazine/1354588640/1622100821/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 46</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </a>

            <a href="{{ url('user/read/issue_46') }}" class="mt-4">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="https://files.magzter.com/resize/magazine/1343918525/1622011952/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 46</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </a>

            <a href="{{ url('user/read/issue_46') }}" class="mt-4">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="https://files.magzter.com/resize/magazine/1359122596/1622010544/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 46</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </a>

            <a href="{{ url('user/read/issue_47') }}" class="mt-4">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="https://files.magzter.com/resize/magazine/1429714855/1620997113/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 46</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </a>

            <a href="{{ url('user/read/issue_46') }}" class="mt-4">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full" src="https://files.magzter.com/resize/magazine/1338193253/1621603041/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 46</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </a>

        </div>



    </div>

</main>

@endsection