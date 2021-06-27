@extends('layouts.main')
@section('content')
<section class="mx-auto mt-12 flex sm:max-w-6xl p-4 w-full border-2 rounded-lg shadow-lg">
    <form action="{{route('make.payment')}}" method="POST">
        @csrf
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
                                <!-- Validation Errors -->
                                <x-auth-validation-errors class="mb-2" :errors="$errors" />
                                <span class="text-green-700 font-semibold">Customer Information (If gift, input information of beneficiary)</span>
                                <div class="pb-3">
                                    <input type="text" name="email" value="{{ old('email') ?? auth()->user()->email ?? ''}}" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="E-mail">
                                </div>
                                <span class="text-green-700 font-semibold">Shipping/Billing Information</span>
                                <div class="grid md:gap-2">
                                    <input type="text" name="name" value="{{ old('name') ?? auth()->user()->name ?? '' }}" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Name*">
                                </div>
                                <input type="text" name="company" value="{{ old('company') ?? auth()->user()->company ?? '' }}" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Company (optional)">
                                <input type="text" name="address" value="{{ old('address') ?? auth()->user()->shippingInfo->address ?? '' }}" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Address*">
                                <input type="text" name="apartment" value="{{ old('apartment') ?? auth()->user()->shippingInfo->apartment ?? '' }}" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Apartment, suite, etc. (optional)">
                                <div class="grid md:grid-cols-3 md:gap-2">
                                    <input type="text" name="zip_code" value="{{ old('zip_code') ?? auth()->user()->shippingInfo->zip_code ?? '' }}" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Zipcode*">
                                    <input type="text" name="city" value="{{ old('city') ?? auth()->user()->shippingInfo->city ?? '' }}" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="City*">
                                    <input type="text" name="state" value="{{ old('state') ?? auth()->user()->shippingInfo->state ?? '' }}" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="State*">
                                </div>

                                <div class="mt-2">
                                    <span class="text-green-700 font-semibold">Country</span>
                                    <select name="country" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm">
                                        <option value="">-- Select your country --</option>
                                        @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{$country->country}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mt-2">
                                    <span class="text-green-700 font-semibold">Phone Number</span>
                                </div>
                                <div class="mt-2">
                                    <input type="tel" name="phone_no" value="{{ old('phone_no') ?? auth()->user()->phone_no ?? '' }}" placeholder="Phone Number*" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 text-sm">
                                </div>
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


    </form>
</section>

@endsection