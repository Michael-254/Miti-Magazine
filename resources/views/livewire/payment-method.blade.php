<div>
    <div class="container mx-auto mt-4 mb-4" x-data="{ tab: 'tab1' }">
        <h2 class="mt-1 pb-1 font-bold text-xl text-green-700 border-b border-green-600">Choose Payment Method</h2>
        <ul class="flex border-b mt-6">
            <li class="-mb-px mr-1">
                <a class="inline-block rounded-t py-2 px-4 font-semibold hover:text-blue-800" :class="{ 'bg-gray-300 border-l border-t border-r' : tab === 'tab1' }" @click.prevent="tab = 'tab1'">
                    <img src="/storage/card.png" alt="" class="w-20 cursor-pointer">
                </a>
            </li>
            <li class="-mb-px mr-1">
                <a class="inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" :class="{ 'bg-gray-300 border-l border-t border-r' : tab === 'tab2' }" @click.prevent="tab = 'tab2'">
                    <img src="/storage/mpesa.png" alt="" class="w-20 cursor-pointer">
                </a>
            </li>
            <li class="-mb-px mr-1">
                <a class="inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" :class="{ 'bg-gray-300 border-l border-t border-r' : tab === 'tab3' }" @click.prevent="tab = 'tab3'">
                    <img src="/storage/airtel.png" alt="" class="w-20 cursor-pointer">
                </a>
            </li>
        </ul>
        <div class="content bg-white px-4 py-4 border-l border-r border-b pt-4">
            <div x-cloak x-show="tab === 'tab1'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100">
                Lipa na Card

                <div class="flex justify-between items-center pt-4">
                    <a href="{{route('choose.plan')}}" class="h-12 w-24 text-blue-500 text-sm font-medium">Change Plan</a>
                    <x-button class="bg-green-800 hover:bg-blue-700 text-white">Subscribe</x-button>
                </div>
            </div>
            <div x-cloak x-show="tab === 'tab2'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100">
                Lipa Na Mpesa

                <div class="flex justify-between items-center pt-4">
                    <a href="{{route('choose.plan')}}" class="h-12 w-24 text-blue-500 text-sm font-medium">Change Plan</a>
                    <x-button class="bg-green-800 hover:bg-blue-700 text-white">Subscribe</x-button>
                </div>
            </div>
            <div x-cloak x-show="tab === 'tab3'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100">
                Lipa na Airtel

                <div class="flex justify-between items-center pt-4">
                    <a href="{{route('choose.plan')}}" class="h-12 w-24 text-blue-500 text-sm font-medium">Change Plan</a>
                    <x-button class="bg-green-800 hover:bg-blue-700 text-white">Subscribe</x-button>
                </div>
            </div>

        </div>
    </div>
</div>