@extends('layouts.main')
@section('content')
<section class="mx-auto mt-12 flex sm:max-w-6xl p-4 w-full border-2 rounded-lg shadow-lg">
    <form action="https://payments.ipayafrica.com/v3/ke" method="POST"> 
        @foreach ($fields as $key => $value)
            <input name="{{ $key }}" type="hidden" value="{{ $value }}"></br>
        @endforeach
        <button type="submit">Pay with iPay</button>   
    </form>
</section>

@endsection