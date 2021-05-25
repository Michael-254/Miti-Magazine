@extends('layouts.master')

@section('content')


<main class="mt-4 w-full flex flex-col items-center">

    <div class="max-w-5xl mx-4">
        <h2 class="mt-1 pb-1 font-bold text-xl text-green-500 border-b border-green-600">Recent Miti Issues</h2>

        <div class="flex flex-col sm:flex-row sm:-mx-2">
            <div class="mt-4 sm:w-1/3">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full transform rotate-0 lg:hover:-rotate-45 transition-transform duration-9000 ease-out" src="https://files.magzter.com/resize/magazine/1423230088/1616593384/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 47</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </div>

            <div class="mt-4 sm:w-1/3">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full lg:transform hover:translate-x-1/2 transition-transform duration-9000 ease-out" src="https://files.magzter.com/resize/magazine/1523352681/1618119700/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 47</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </div>

            <div class="mt-4 sm:w-1/3">
                <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                    <div class="border rounded-md px-2 py-2">
                        <img class="object-fill h-48 w-full transform rotate-0 lg:hover:-rotate-45 transition-transform duration-9000 ease-out" src="https://files.magzter.com/resize/magazine/1353482851/1616657207/thumb/1.jpg">
                    </div>
                    <div class="mt-4 font-bold">Issue 47</div>
                    <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                </div>
            </div>
        </div>


    </div>

</main>

@endsection