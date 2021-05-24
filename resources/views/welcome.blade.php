<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>BGF | Miti Magazine Online</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @livewireStyles
</head>

<body class="font-sans">
    <div class="relative pb-32" style="min-height: 25vh;">
        <div class="absolute top-0 w-full h-full bg-center bg-cover" style="background-image: url(/storage/drp.jpg);">
            <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
        </div>

        <nav x-data="{ open: false }" class="relative">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <img src="{{asset('storage/logo.png')}}" class="block h-10 w-auto lg:w-16 lg:h-16 fill-current" alt="Logo Image" />
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                <h2 class="text-blue-500 text-xl">Miti Magazine</h2>
                            </x-nav-link>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="hidden space-x-2 sm:-my-px sm:ml-5 sm:flex mr-3">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                <p class="border rounded-md outline-none text-xs uppercase font-bold px-4 py-2 
                                   bg-green-500 hover:bg-blue-600 hover:text-white">
                                    Get Started
                                </p>
                            </x-nav-link>
                        </div>
                        @guest
                        <div class="hidden space-x-2 sm:-my-px sm:ml-2 sm:flex">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                Login
                            </x-nav-link>
                        </div>
                        @endguest

                        @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-white hover:text-blue-500 hover:border-gray-300 focus:outline-none focus:text-white focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
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
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                <div class="pt-1 pb-1 space-y-1">
                    <x-responsive-nav-link>
                        <p class="border rounded-md outline-none max-w- text-xs uppercase font-bold px-2 py-2 
                                   bg-green-500 hover:bg-blue-600 hover:text-white">
                            Get Started
                        </p>
                    </x-responsive-nav-link>
                </div>

                @guest
                <div class="pt-1 pb-1 space-y-1">
                    <x-responsive-nav-link>
                        Login
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


        <div class="container relative mx-auto">
            <div class="items-center flex flex-wrap">
                <div class="w-full lg:w-6/12 px-4 mt-16 ml-auto mr-auto text-center">
                    <div>
                        <h1 class="text-white font-semibold text-5xl">Welcome to Miti Online</h1>
                        <p class="mt-4 text-lg text-gray-300">Miti is a high-quality quarterly on forestry in East Africa, providing specialist information beautifully presented. Since 2009.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <main class="mt-4 w-full flex flex-col items-center">

        <div class="max-w-5xl mx-4">
            <h2 class="mt-1 pb-1 font-bold text-xl text-green-500 border-b border-green-600">Recent Miti Issues</h2>

            <div class="flex flex-col sm:flex-row sm:-mx-2">
                <div class="mt-4 sm:w-1/3">
                    <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                        <div class="border rounded-md px-2 py-2">
                            <img class="object-fill h-48 w-full transform rotate-0 lg:hover:-rotate-45 transition-transform duration-9000 ease-out" src="https://files.magzter.com/resize/magazine/1423230088/1616593384/thumb/1.jpg">
                        </div>
                        <div class="mt-4 font-bold">Issue 47</div>
                        <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                    </div>
                </div>

                <div class="mt-4 sm:w-1/3">
                    <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                        <div class="border rounded-md px-2 py-2">
                            <img class="object-fill h-48 w-full lg:transform hover:translate-x-1/2 transition-transform duration-9000 ease-out" src="https://files.magzter.com/resize/magazine/1523352681/1618119700/thumb/1.jpg">
                        </div>
                        <div class="mt-4 font-bold">Issue 47</div>
                        <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                    </div>
                </div>

                <div class="mt-4 sm:w-1/3">
                    <div class="bg-white h-full p-8 border-b-4 border-green-500 rounded-lg flex flex-col items-center sm:mx-2 sm:p-3 md:p-8">
                        <div class="border rounded-md px-2 py-2">
                            <img class="object-fill h-48 w-full transform rotate-0 lg:hover:-rotate-45 transition-transform duration-9000 ease-out" src="https://files.magzter.com/resize/magazine/1353482851/1616657207/thumb/1.jpg">
                        </div>
                        <div class="mt-4 font-bold">Issue 47</div>
                        <div class="text-center mt-2 text-gray-600 text-sm">Captured Topics can be put here</div>
                    </div>
                </div>
            </div>


        </div>

        @livewire('homepage-plans')

    </main>

    <footer class="footer-1 bg-black text-white py-8 sm:py-12 mt-4">
        <div class="container mx-auto px-8">

            <div class="sm:flex sm:flex-wrap sm:-mx-4 mt-2 pt-6 sm:mt-2 sm:pt-12 border-t">
                <div class="sm:w-full px-4 md:w-1/4">
                    <h5 class="text-xl font-bold mb-6 sm:text-center xl:text-left">Stay connected</h5>
                    <div class="flex sm:justify-center xl:justify-start">
                        <a href="" class="w-8 h-8 border border-2 border-gray-400 rounded-full text-center py-1 text-gray-600 hover:text-white hover:bg-blue-600 hover:border-blue-600">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="" class="w-8 h-8 border border-2 border-gray-400 rounded-full text-center py-1 ml-2 text-gray-600 hover:text-white hover:bg-blue-400 hover:border-blue-400">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="" class="w-8 h-8 border border-2 border-gray-400 rounded-full text-center py-1 ml-2 text-gray-600 hover:text-white hover:bg-red-600 hover:border-red-600">
                            <i class="fab fa-google-plus-g"></i>
                        </a>
                    </div>
                </div>
                <div class="px-4 sm:w-1/2 md:w-1/4 mt-4 md:mt-0">
                    <h6 class="font-bold mb-2">Address</h6>
                    <address class="not-italic mb-4 text-sm">
                        Better Globe Forestry Ltd.<br>
                        P.o Box 823-00606.<br>
                        Nairobi Kenya.<br>
                        Phone: +254 (0)20 3594200.<br>
                        Email 1: info@betterglobeforestry.com.<br>
                    </address>
                </div>
                <div class="px-4 sm:w-1/2 md:w-1/4 mt-4 md:mt-0">
                    <h6 class="font-bold mb-2">Quick Links</h6>
                    <a href="https://betterglobeforestry.com/">
                        <p class="mb-4 text-sm">Better Globe Forestry <strong>Website</strong></p>
                    </a>
                </div>
                <div class="px-4 md:w-1/4 md:ml-auto mt-6 sm:mt-4 md:mt-0">
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


    @livewireScripts
    <script src="https://kit.fontawesome.com/43d7c4e320.js" crossorigin="anonymous"></script>
</body>

</html>