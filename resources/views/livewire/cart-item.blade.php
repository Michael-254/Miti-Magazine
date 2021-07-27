<div>
    @if(Cart::getContent()->where('id',$magazine->id)->count())
    <form wire:submit.prevent="remove({{$magazine->id}})" method="POST">
        <div class="text-center text-gray-600 text-sm mb-2">
            <button type="submit" class="bg-green-700 btn btn-rounded btn-secondary btn-xs" wire:loading.class="cursor-default">
                <span wire:loading.remove>Remove from Cart</span><span wire:loading wire:target="remove">Removing...</span>
            </button>
        </div>
    </form>
    @else
    <form wire:submit.prevent="cart({{$magazine->id}})" method="POST">
        <div class="text-center text-gray-600 text-sm mb-1">
            <input wire:model.defer="quantity" type="number" class="text-sm sm:text-base px-2 pr-2 rounded-lg border border-gray-400 py-1 focus:outline-none focus:border-blue-400" style="width: 50px" />
            <button type="submit" wire:loading.class="bg-gray-200 cursor-default" class="btn btn-rounded btn-success btn-xs" wire:loading.attr="disabled">
                <span wire:loading.remove>Add to cart</span><span wire:loading wire:target="cart">Adding...</span>
            </button>
        </div>
    </form>
    @endif
</div>