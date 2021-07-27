<div class="mb-4 px-4 py-3 leading-normal text-blue-700 rounded-lg text-right" role="alert">
    <i class="fa fa-shopping-cart"></i>
    Cart ({{Cart::getContent()->count()}})
    @if(Cart::getContent()->count())
    <a href="{{route('checkout.cart')}}" class="mt-1 btn btn-success btn-sm">Check out</a>
    @endif
</div>