@extends('layouts.master')

@section('content')


<main class="my-8 w-full flex flex-col items-center">

    <div class="max-w-6xl mx-4 js-show-on-scroll">
        <h2 class="mt-1 pb-1 font-bold text-xl text-green-500 border-b border-green-600">Recent Miti Issues</h2>

        <div class="flex flex-col sm:grid sm:grid-cols-3 sm:-mx-2">
            <a href="{{ url('user/read/issue_47') }}" class="mt-4">
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