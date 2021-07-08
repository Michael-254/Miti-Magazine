@if(session()->has('message'))
<div class="alert alert-success flex items-center">
    <i class="fa fa-check mr-1"></i>
    <p class="mb-0">
        {{ session()->get('message') }}
    </p>
</div>
@endif
@if(session()->has('error'))
<div class="alert alert-danger flex items-center">
    <i class="fa fa-times mr-1"></i>
    <p class="mb-0">
        {{ session()->get('error') }}
    </p>
</div>
@endif