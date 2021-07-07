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
      <li wire:click="copySelected('1')" class="py-2 px-6  rounded-t-lg text-xs md:text-sm {{ $copies ==  '1' ? 'bg-gray-300' : ''  }}">Single Copy</li>
      <li wire:click="copySelected('5')" class="py-2 px-6  rounded-t-lg text-xs md:text-sm {{ $copies ==  '5' ? 'bg-gray-300' : ''  }}">5 Copies</li>
      <li wire:click="copySelected('10')" class="py-2 px-6  rounded-t-lg  text-xs md:text-sm {{ $copies ==  '10' ? 'bg-gray-300' : ''  }}">10 Copies</li>
    </ul>
  </div>

  <!-- component -->
  <div class="flex flex-col sm:flex-row justify-center mb-6 sm:mb-0 pricing-table my-12">
    <div class="col-lg-4 col-md-12 col-12">
      <div class="plan shadow-md">
        <div class="plan-header">
          <h4 class="font-bold text-3xl text-green-600">Digital Plan</h4>
          <div class="plan-price text-green-700"><sup>{{$plans->currency()}}</sup>{{$plans->amounts->digital}} </div>
        </div>
        <div class="plan-list text-green-700">
          <ul>
            <li><i class="fas fa-globe-americas"></i>Unlimited Websites</li>
            <li><i class="fa fa-thumbs-up"></i>Unlimited Storage</li>
            <li><i class="fa fa-signal"></i>Unlimited Bandwidth</li>
            <li><i class="fa fa-user"></i>1000 Email Addresses</li>
            <li><i class="fa fa-star"></i>Free domain with annual plan</li>
            <li><i class="fa fa-rocket"></i>4X Processing Power</li>
            <li><i class="fa fa-server"></i>Premium DNS</li>
          </ul>
          <div class="plan-button">
          <form action="{{route('chosen.plan')}}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" value="{{$plans->id}}">
            <input type="hidden" name="plan_type" value="digital">
            <x-button class="bg-green-600 hover:bg-blue-600">Choose Plan</x-button>
          </form>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-12 col-12">
      <div class="plan shadow-md">
        <div class="plan-header">
          <h4 class="font-bold text-3xl text-green-600">Digital & Printed Plan</h4>
          <div class="plan-price text-green-700"><sup>{{$plans->currency()}}</sup>{{$plans->amounts->combined}}</div>
        </div>
        <div class="plan-list text-green-700">
          <ul>
            <li><i class="fas fa-globe-americas"></i>Unlimited Websites</li>
            <li><i class="fa fa-thumbs-up"></i>Unlimited Storage</li>
            <li><i class="fa fa-signal"></i>Unlimited Bandwidth</li>
            <li><i class="fa fa-user"></i>1000 Email Addresses</li>
            <li><i class="fa fa-star"></i>Free domain with annual plan</li>
            <li><i class="fa fa-rocket"></i>4X Processing Power</li>
            <li><i class="fa fa-server"></i>Premium DNS</li>
          </ul>
          <div class="plan-button">
            <form action="{{route('chosen.plan')}}" method="POST">
              @csrf
              <input type="hidden" name="plan_id" value="{{$plans->id}}">
              <input type="hidden" name="plan_type" value="combined">
              <x-button class="bg-green-600 hover:bg-blue-600">Choose Plan</x-button>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>



</div>