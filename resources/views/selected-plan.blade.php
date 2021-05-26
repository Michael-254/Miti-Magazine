@extends('layouts.master')
@section('content')

<section class="mx-auto flex sm:max-w-6xl p-4 w-full border-2 rounded-lg shadow-lg">
    <div class="flex-1 lg:flex lg:space-x-7 lg:py-5">
        <div>
            <div>
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="md:flex ">
                        <div class="w-full p-4 px-5 py-5">
                            <div class="flex flex-row">
                                <h2 class="mt-1 pb-1 font-bold text-xl text-green-700 border-green-600">Your Information</h2>
                            </div>
                            <div class="flex flex-row text-xs text-green-700 pt-6 pb-5"> <span class="font-bold">Information</span> <small class="text-gray-400 ml-1">></small> <span class="text-gray-400 ml-1">Shopping</span> <small class="text-green-700 ml-1">></small> <span class="text-green-700 ml-1">Payment</span> </div> <span class="text-green-700 font-semibold">Customer Information</span>
                            <div class="relative pb-5"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="E-mail"> <span class="absolute text-blue-500 right-2 top-4 font-medium text-sm">Log out</span> </div> <span class="text-green-700 font-semibold">Shipping/Billing Information</span>
                            <div class="grid md:grid-cols-2 md:gap-2"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="First name*"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Last name*"> </div> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Company (optional)"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Address*"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Apartment, suite, etc. (optional)">
                            <div class="grid md:grid-cols-3 md:gap-2"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Zipcode*"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="City*"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="State*"> </div> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Country*"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Phone Number*">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 px-5 py-5 mt-4 lg:mt-16">
            <h2 class="mt-1 pb-1 font-bold text-xl text-green-700 border-b border-green-600">Selected Plan Kenya</h2>

            <div class="bg-gray-100 mt-4 dark:bg-gray-800 bg-opacity-95 border-opacity-60 | p-4 border-solid rounded-md border-2">
                <div>
                    <p class="text-gray-900 dark:text-gray-300 font-semibold">Miti Magazine 1 Year Subscription</p>
                    <p class="text-gray-900 dark:text-gray-300 text-sm mt-3">You will be charged</p>
                    <p class="text-black dark:text-gray-100 text-justify font-bold mt-3">$15 000</p>
                    <p class="text-gray-900 dark:text-gray-300 text-xs mt-3">After 1 Year, we will automatically renew your subscription </p>
                </div>
            </div>

            <div class="container mx-auto mt-4 mb-4" x-data="{ tab: 'tab1' }">
                <h2 class="mt-1 pb-1 font-bold text-xl text-green-700 border-b border-green-600">Choose Payment Method</h2>
                <ul class="flex border-b mt-6">
                    <li class="-mb-px mr-1">
                        <a class="inline-block rounded-t py-2 px-4 font-semibold hover:text-blue-800" :class="{ 'bg-gray-300 border-l border-t border-r' : tab === 'tab1' }" @click.prevent="tab = 'tab1'"><img src="/storage/card.png" alt="" class="w-20 cursor-pointer"></a>
                    </li>
                    <li class="-mb-px mr-1">
                        <a class="inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" :class="{ 'bg-gray-300 border-l border-t border-r' : tab === 'tab2' }" @click.prevent="tab = 'tab2'"><img src="/storage/mpesa.png" alt="" class="w-20 cursor-pointer"></a>
                    </li>
                    <li class="-mb-px mr-1">
                        <a class="inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" :class="{ 'bg-gray-300 border-l border-t border-r' : tab === 'tab3' }" @click.prevent="tab = 'tab3'"><img src="/storage/airtel.png" alt="" class="w-20 cursor-pointer"></a>
                    </li>
                </ul>
                <div class="content bg-white px-4 py-4 border-l border-r border-b pt-4">
                    <div x-show="tab === 'tab1'">
                        Tab1 content. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt sunt,

                        <div class="flex justify-between items-center pt-4">
                            <a href="{{route('choose.plan')}}" class="h-12 w-24 text-blue-500 text-sm font-medium">Change Plan</a>
                            <x-button class="bg-green-800 hover:bg-blue-700 text-white">Subscribe</x-button>
                        </div>
                    </div>
                    <div x-show="tab === 'tab2'">
                        Tab2 content. Lorem ipsum dolor sit amet, consectetur adipisicing elit.

                        <div class="flex justify-between items-center pt-4">
                            <a href="{{route('choose.plan')}}" class="h-12 w-24 text-blue-500 text-sm font-medium">Change Plan</a>
                            <x-button class="bg-green-800 hover:bg-blue-700 text-white">Subscribe</x-button>
                        </div>
                    </div>
                    <div x-show="tab === 'tab3'">
                        Tab3 content. Lorem ipsum dolor sit amet, consectetur adipisicing elit.

                        <div class="flex justify-between items-center pt-4">
                            <a href="{{route('choose.plan')}}" class="h-12 w-24 text-blue-500 text-sm font-medium">Change Plan</a>
                            <x-button class="bg-green-800 hover:bg-blue-700 text-white">Subscribe</x-button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>



</section>

@endsection