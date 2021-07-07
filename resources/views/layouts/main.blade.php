<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Miti Magazine | Better Globe Forestry LTD</title>

    <!-- Styles -->
    <link href="{{asset('temp/css/plugins.css')}}" rel="stylesheet">
    <link href="{{asset('temp/css/style.css')}}" rel="stylesheet">

    <link href="{{asset('temp/css/color-variations/green.html')}}" rel="stylesheet" type="text/css" media="screen">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v1.9.4/dist/alpine.js" defer></script>
    <!-- Scripts -->
    @livewireStyles
    @stack('styles')
</head>

<body>



    <div class="body-inner">

        <div id="topbar">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="top-menu">
                            <li><a href="#">Phone: +254 (0)20 3594200</a></li>
                            <li><a href="#">Email: miti-magazine@betterglobeforestry.com</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 d-none d-sm-block">
                        <div class="social-icons social-icons-colored-hover">
                            <ul>
                                <li class="social-facebook"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li class="social-twitter"><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li class="social-google"><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                <li class="social-youtube"><a href="#"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <header id="header">
            <div class="header-inner border-b-4 border-gray-300">
                <div class="container">

                    <div class="flex items-center" id="logo">
                        <img src="{{asset('storage/logo.png')}}" class="block h-12 w-auto fill-current px-6 md:px-3" alt="Logo Image" />
                        <a href="{{route('landing.page')}}">
                            <h2 class="hidden sm:flex mt-1.5 text-blue-600 text-xl font-bold">Miti Magazine</h2>
                        </a>
                    </div>

                    <div id="mainMenu-trigger"> <a class="lines-button x"><span class="lines"></span></a> </div>


                    <div id="mainMenu">
                        <div class="container">
                            <nav>
                                <ul>
                                    <li><a href="{{route('landing.page')}}">Home</a></li>
                                    @auth
                                    <li class="dropdown"><a href="#">{{ Auth::user()->name }}</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{route('profile.show')}}">My Profile</a></li>
                                            <li><a href="widgets.html">My Subscription</a></li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <x-dropdown-link class="font-bold" :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                        Log out
                                                    </x-dropdown-link>
                                                </form>
                                            </li>
                                        </ul>
                                        @else
                                    <li class="dropdown"><a href="{{route('login')}}">Login</a></li>
                                    @endauth
                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        @yield('content')
        <footer id="footer">
            <div class="footer-content">
                <div class="container">
                    <div class="flex flex-wrap mx-auto max-w-7xl">
                        <div class="col-md-4">
                            <div class="icon-box effect small clean">
                                <div class="icon">
                                    <a href="#"><i class="icon-clock"></i></a>
                                </div>
                                <h3>Quick Links</h3>
                                <p class="mb-4 text-sm">Better Globe Forestry <strong>Website</strong></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="icon-box effect small clean">
                                <div class="icon">
                                    <a href="#"><i class="fas fa-map-marker-alt"></i></a>
                                </div>
                                <h3>Better Globe Forestry Ltd.</h3>
                                <p><strong>Address:</strong>
                                    <br> P.o Box 823-00606.
                                    <br> Nairobi Kenya.
                                    <br> 
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="icon-box effect small clean">
                                <div class="icon">
                                    <a href="#"><i class="icon-phone"></i></a>
                                </div>
                                <h3>Contact</h3>
                                <p><strong>Phone:</strong>
                                    <br> +254 (0)20 3594200.
                                    <br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">

                            <div class="social-icons social-icons-colored float-left">
                                <ul>
                                    <li class="social-facebook"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li class="social-twitter"><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li class="social-youtube"><a href="#"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="copyright-text text-center">&copy; 2021 Better Globe Forestry. All Rights Reserved.</div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>


    <a id="scrollTop"><i class="icon-chevron-up"></i><i class="icon-chevron-up"></i></a>


</body>
@livewireScripts
<script src="{{asset('temp/js/jquery.js')}}"></script>
<script src="{{asset('temp/js/plugins.js')}}"></script>

<script src="{{asset('temp/js/functions.js')}}"></script>
@yield('scripts')

</html>