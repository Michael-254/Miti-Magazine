<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Miti Magazine | Better Globe Forestry LTD</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        [x-cloak] {
            display: none;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @livewireStyles
    @stack('styles')
</head>

<body class="text-gray-800 antialiased font-sans">

    <div class="container h-16 bg-black {{ Request::path() ==  '/' ? 'top-0 absolute z-50' : ''  }}">
        <nav x-data="{ open: false }">
            <!-- Primary Navigation Menu -->
            <div class="h-16 px-6 flex items-center justify-between">
                <div class="flex">
                    <img src="{{asset('storage/logo.png')}}" class="block h-10 w-auto fill-current" alt="Logo Image" />
                    <x-nav-link :href="route('dashboard')">
                        <h2 class="hidden sm:flex text-blue-500 text-xl">Miti Magazine</h2>
                    </x-nav-link>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <div class="hidden space-x-2 sm:-my-px sm:ml-5 sm:flex mr-3">
                        <x-nav-link :href="route('landing.page')">
                            Home
                        </x-nav-link>
                    </div>
                    <div class="hidden space-x-2 sm:-my-px sm:ml-5 sm:flex mr-3">
                        <x-nav-link href="#contact-info">
                            Contact Information
                        </x-nav-link>
                    </div>
                    @guest
                    <div class="hidden space-x-2 sm:-my-px sm:ml-5 sm:flex mr-3">
                        <x-nav-link :href="route('login')">
                            <p class="border rounded-md outline-none text-xs uppercase font-bold px-4 py-2 
                                   bg-blue-600 hover:bg-blue-800 hover:text-white">
                                Login
                            </p>
                        </x-nav-link>
                    </div>
                    @endguest

                    @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="ml-3 flex items-center text-sm font-medium text-white hover:text-blue-500 hover:border-gray-300 focus:outline-none focus:text-white focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link href="{{route('profile.show')}}">
                                My Profile
                            </x-dropdown-link>
                            <x-dropdown-link href="#">
                                My Subscription
                            </x-dropdown-link>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                    @endauth
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-black absolute w-full">
                <div class="pt-1 pb-1 space-y-1">
                    <x-responsive-nav-link :href="route('landing.page')">
                        Home
                    </x-responsive-nav-link>
                </div>
                @guest
                <div class="pt-1 pb-1 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        <p class="border rounded-md outline-none max-w- text-xs uppercase font-bold px-2 py-2 
                                   bg-blue-600 hover:bg-blue-800 hover:text-white">
                            Login
                        </p>
                    </x-responsive-nav-link>
                </div>
                @endguest
                <!-- Responsive Settings Options -->
                @auth
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <svg class="h-10 w-10 fill-current text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>

                        <div class="ml-3">
                            <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-white">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link :href="route('profile.show')">
                            My Profile
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('dashboard')">
                            My Subscription
                        </x-responsive-nav-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                {{ __('Log out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </nav>
    </div>

    @yield('content')

    <footer class="bg-black text-white py-8 sm:py-12 mt-4">
        <div class="container mx-auto px-8">

            <div class="sm:flex sm:flex-wrap sm:-mx-4 mt-2 pt-6 sm:mt-2 sm:pt-12 border-t">
                <div class="sm:w-full px-4 md:w-1/4" data-aos="fade-right">
                    <h5 class="text-xl font-bold mb-6 sm:text-center xl:text-left">Stay connected</h5>
                    <div class="flex sm:justify-center xl:justify-start">
                        <a href="" class="w-8 h-8 border-2 border-gray-400 rounded-full text-center py-1 text-gray-600 hover:text-white hover:bg-blue-600 hover:border-blue-600">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="" class="w-8 h-8 border-2 border-gray-400 rounded-full text-center py-1 ml-2 text-gray-600 hover:text-white hover:bg-blue-400 hover:border-blue-400">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="" class="w-8 h-8 border-2 border-gray-400 rounded-full text-center py-1 ml-2 text-gray-600 hover:text-white hover:bg-red-600 hover:border-red-600">
                            <i class="fab fa-google-plus-g"></i>
                        </a>
                    </div>
                </div>
                <div id="contact-info" class="px-4 sm:w-1/2 md:w-1/4 mt-4 md:mt-0" data-aos="fade-right">
                    <h6 class="font-bold mb-2">Address</h6>
                    <address class="not-italic mb-4 text-sm">
                        Better Globe Forestry Ltd.<br>
                        P.o Box 823-00606.<br>
                        Nairobi Kenya.<br>
                        Phone: +254 (0)20 3594200.<br>
                        Email 1: info@betterglobeforestry.com.<br>
                    </address>
                </div>
                <div class="px-4 sm:w-1/2 md:w-1/4 mt-4 md:mt-0" data-aos="fade-right">
                    <h6 class="font-bold mb-2">Quick Links</h6>
                    <a href="https://betterglobeforestry.com/">
                        <p class="mb-4 text-sm">Better Globe Forestry <strong>Website</strong></p>
                    </a>
                </div>
                <div class="px-4 md:w-1/4 md:ml-auto mt-6 sm:mt-4 md:mt-0" data-aos="fade-right">
                    <div class="lg:w-1/3">
                        <h2 style="font-family: 'Baloo Tamma 2', cursive;" class=" font-bold text-gray-100 mb-4">
                            Our Newsletter
                        </h2>
                        <div class="md:flex text-xs">
                            Coming Soon...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="bg-black text-center text-xs text-white py-3">
        <p>Copyright © 2021 <a href="#">Better Globe Forestry</a>.</p>
    </div>

</body>
@livewireScripts
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    AOS.init({
        delay: 200,
        duration: 1200,
        once: true,
    })
</script>

</html>