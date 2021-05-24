<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="card-title text-center">
            <h4 class=" text-green-600 text-2xl">Login</h4>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-1" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-2" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-1">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="flex justify-between mt-2">
                <div class="block mt-1">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="border-gray-300 text-blue-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                        <span class="ml-1 text-blue-600">Remember me</span>
                    </label>
                </div>
                <div>
                    @if (Route::has('password.request'))
                    <a class="underline text-sm text-red-500 hover:text-blue-800" href="{{ route('password.request') }}">
                        Forgot your password
                    </a>
                    @endif
                </div>
            </div>

            <div class="flex justify-between">
                <div class="flex items-center mt-2">
                    <a href="{{route('register')}}" class="btn bg-blue-500 float-right btn-inline text-white hover:bg-blue-800">Register</a>
                </div>
                <div class="flex items-center justify-end mt-2">
                    <button type="submit" class="btn bg-green-600 float-right btn-inline text-white hover:bg-green-800">Login</button>
                </div>
            </div>

            <div class="login-footer">
                <div class="divider">
                    <div class="divider-text">OR</div>
                </div>
                <div class="footer-btn d-inline">
                    <a href="{{route('socialite','facebook')}}" class="btn btn-facebook"><span class="fa fa-facebook"></span></a>
                    <a href="#" class="btn btn-twitter white"><span class="fa fa-twitter"></span></a>
                    <a href="{{route('socialite','google')}}" class="btn btn-google"><span class="fa fa-google"></span></a>
                </div>
            </div>

        </form>
    </x-auth-card>
</x-guest-layout>