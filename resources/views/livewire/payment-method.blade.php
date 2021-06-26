<div>
    <div class="container mx-auto mt-4 mb-4">
        <h2 class="mt-1 pb-1 font-bold text-xl text-green-700 border-b border-green-600">Choose Payment Method</h2>

        <div class="content bg-white px-4 py-4 border-l border-r border-b">
            <ul class="flex justify-between border-b">
                <li class="-mb-px mr-1 flex items-center space-x-1">
                    <input type="radio" class="text-yellow-600" name="payment_method" value="ipay" checked>
                    <a class="inline-block rounded-t py-2 px-4 font-semibold hover:text-blue-800">
                        <img src="/storage/card.png" alt="" class="w-20 cursor-pointer">
                    </a>
                </li>

                <li class="-mb-px mr-1 flex items-center">
                    <input type="radio" name="payment_method" value="paypal">
                    <a class="inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold">
                        <img src="/storage/paypal.png" alt="" class="w-20 cursor-pointer">
                    </a>
                </li>
            </ul>

            <div>

                <div class="flex justify-between items-center pt-4">
                    <a href="{{route('choose.plan')}}" class="h-12 w-24 text-blue-500 text-sm font-medium">Change Plan</a>
                    <x-button type="submit" class="bg-green-800 hover:bg-blue-700 text-white">Subscribe</x-button>
                </div>
            </div>
        </div>
    </div>
</div>