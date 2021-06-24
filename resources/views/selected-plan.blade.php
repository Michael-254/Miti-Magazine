@extends('layouts.main')
@section('content')

<section class="mx-auto mt-12 flex sm:max-w-6xl p-4 w-full border-2 rounded-lg shadow-lg" data-aos="fade-up-right">
    <div class="flex-1 lg:flex lg:space-x-7 lg:py-5">
        <div>
            <div>
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="md:flex ">
                        <div class="w-full p-4 px-5 py-5">
                            <div class="flex flex-row">
                                <h2 class="mt-1 pb-1 font-bold text-xl text-green-700 border-green-600">Your Information</h2>
                            </div>
                            <div class="flex flex-row text-xs text-green-700 pt-6 pb-5">
                                <span class="font-bold">Information</span>
                                <small class="text-gray-400 ml-1">></small>
                                <span class="text-gray-400 ml-1">Shopping</span>
                                <small class="text-green-700 ml-1">></small>
                                <span class="text-green-700 ml-1">Payment</span>
                            </div>
                            <span class="text-green-700 font-semibold">Customer Information (if gift, input email of beneficiary)</span>
                            <div class="pb-3">
                                <input type="text" name="mail" value="{{auth()->user()->email ?? ''}}" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="E-mail">
                            </div>
                            <span class="text-green-700 font-semibold">Shipping/Billing Information</span>
                            <div class="grid md:grid-cols-2 md:gap-2">
                                <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="First name*"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Last name*">
                            </div>
                            <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Company (optional)">
                            <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Address*">
                            <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Apartment, suite, etc. (optional)">
                            <div class="grid md:grid-cols-3 md:gap-2"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Zipcode*">
                                <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="City*">
                                <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="State*">
                            </div>
                            <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Country*"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Phone Number*">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 px-5 py-5 mt-4 lg:mt-16">
            <h2 class="mt-1 pb-1 font-bold text-xl text-green-700 border-b border-green-600">Selected Plan {{$currency->location}}</h2>

            <div class="bg-gray-100 mt-4 dark:bg-gray-800 bg-opacity-95 border-opacity-60 | p-4 border-solid rounded-md border-2">
                <div>
                    <p class="text-gray-900 dark:text-gray-300 font-semibold">Miti Magazine 1 Year Subscription</p>
                    <p class="text-gray-900 dark:text-gray-300 text-sm mt-3">You will be charged</p>
                    <p class="text-black dark:text-gray-100 text-justify font-bold mt-3">{{$currency->currency()}}{{$amount}}</p>
                    <p class="text-gray-900 dark:text-gray-300 text-xs mt-3">After 1 Year, we will automatically renew your subscription </p>
                </div>
            </div>

            @livewire('payment-method')

        </div>
    </div>



</section>

@endsection