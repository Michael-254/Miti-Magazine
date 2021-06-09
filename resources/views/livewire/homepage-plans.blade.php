<div class="mt-12">
  <div class="text-center">
    <h1 class="font-bold text-3xl text-green-600 mb-2">Subscription Plans {{$plans->location ?? ''}}</h1>
    <h4 class="text-gray-600">Our subscription is for 1 year only, meaning 4 issues.</h4>
  </div>

  <div class="mt-8 border-b">
    <ul class='flex justify-center cursor-pointer'>
      <li>
        <svg class="mt-0.5 stroke-current h-9 w-9 animate-spin text-gray-400" wire:loading="wire:loading" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
      </li>
      <li wire:click="copySelected('1')" class="py-2 px-6 bg-white rounded-t-lg text-xs md:text-sm {{ $copies ==  '1' ? 'bg-gray-300' : ''  }}">Single Copy</li>
      <li wire:click="copySelected('5')" class="py-2 px-6 bg-white rounded-t-lg text-xs md:text-sm {{ $copies ==  '5' ? 'bg-gray-300' : ''  }}">5 Copies</li>
      <li wire:click="copySelected('10')" class="py-2 px-6  rounded-t-lg  text-xs md:text-sm {{ $copies ==  '10' ? 'bg-gray-300' : ''  }}">10 Copies</li>
    </ul>
  </div>

  <!-- component -->
  <div class="w-full my-12 text-green-700 font-bold">
    <div class="flex flex-col sm:flex-row justify-center mb-6 sm:mb-0">
      <div class="flex-1 lg:flex-initial lg:w-1/4 border border-gray-400 rounded-md shadow-md bg-white mt-4 flex flex-col">
        <div class="p-8 text-3xl font-bold text-center">Digital</div>
        <div class="border-0 border-grey-light border-t border-solid text-sm">
          <div class="text-center border-0 border-grey-light border-b border-solid py-4">
            Unlimited Ice Creams
          </div>
          <div class="text-center border-0 border-grey-light border-b border-solid py-4">
            Unlimited Cones
          </div>
          <div class="text-center border-0 border-grey-light border-b border-solid py-4">
            Unlimited toppings
          </div>
          <div class="text-center border-0 border-grey-light border-b border-solid py-4">
            Analytics
          </div>
        </div>
        <div class="text-center px-8 pt-8 text-xl mt-auto">
          <span class="font-bold text-sm mr-1">{{$plans->currency()}}</span>{{$plans->amounts->digital}}
          <span class="text-grey-light italic">
            /year
          </span>
        </div>
        <div class="text-center pt-8 mb-8 mt-auto">
          <x-button class="bg-green-600 hover:bg-blue-600">Choose Plan</x-button>
        </div>
      </div>
      <div class="flex-1 lg:flex-initial lg:w-1/4 border border-gray-400 rounded-md  bg-white mt-4 sm:-mt-4 shadow-lg z-30 flex flex-col">
        <div class="w-full p-8 text-3xl font-bold text-center">Printed</div>
        <div class="w-full border-0 border-grey-light border-t border-solid text-sm">
          <div class="text-center border-0 border-grey-light border-b border-solid py-4">
            2 Ice Creams
          </div>
          <div class="text-center border-0 border-grey-light border-b border-solid py-4">
            25 Cones
          </div>
          <div class="text-center border-0 border-grey-light border-b border-solid py-4">
            Unlimited toppings
          </div>
          <div class="text-center border-0 border-grey-light border-b border-solid py-4">
            Analytics
          </div>
        </div>
        <div class="text-center px-8 pt-8 text-xl mt-auto">
          <span class="font-bold text-sm mr-1">{{$plans->currency()}}</span> {{$plans->amounts->printed}}
          <span class="text-grey-light italic">
            /year
          </span>
        </div>
        <div class="w-full text-center mb-8 mt-auto">
          <x-button class="bg-green-600 hover:bg-blue-600">Choose Plan</x-button>
        </div>
      </div>
      <div class="flex-1 lg:flex-initial lg:w-1/4 border border-gray-400 rounded-md shadow-md bg-white mt-4 flex flex-col">
        <div class="p-8 text-3xl font-bold text-center">Digital & Printed</div>
        <div class="border-0 border-grey-light border-t border-solid text-sm">
          <div class="text-center border-0 border-grey-light border-b border-solid py-4">
            Unlimited Ice Creams
          </div>
          <div class="text-center border-0 border-grey-light border-b border-solid py-4">
            Unlimited Cones
          </div>
          <div class="text-center border-0 border-grey-light border-b border-solid py-4">
            Unlimited toppings
          </div>
          <div class="text-center border-0 border-grey-light border-b border-solid py-4">
            Analytics
          </div>
        </div>
        <div class="text-center px-8 pt-8 text-xl mt-auto">
          <span class="font-bold text-sm mr-1">{{$plans->currency()}}</span>{{$plans->amounts->combined}}
          <span class="text-grey-light italic">
            /year
          </span>
        </div>
        <div class="text-center pt-8 mb-8 mt-auto">
          <x-button class="bg-green-600 hover:bg-blue-600">Choose Plan</x-button>
        </div>
      </div>
    </div>
  </div>



</div>