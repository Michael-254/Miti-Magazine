<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current" />
            </a>
        </x-slot>

        <div class="card-title text-center">
            <h4 class=" text-green-600 text-2xl">Register</h4>
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-1" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-1">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-1">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-1">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            </div>

            <div class="flex justify-between mt-1">
                <a class="underline text-sm text-blue-600 hover:text-blue-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <div class="flex items-center justify-end">
                    <button type="submit" class="btn bg-green-600 float-right btn-inline text-white hover:bg-green-800">Register</button>
                </div>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>