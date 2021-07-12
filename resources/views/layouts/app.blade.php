<!DOCTYPE html>

<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Online Miti Magazine | Better Globe Forestry LTD</title>
    <link rel="apple-touch-icon" href="{{asset('/storage/logo.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/storage/logo.png')}}">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/vendors/css/ui/prism.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/vendors/css/forms/select/select2.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/css/pages/invoice.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/css/pages/app-ecommerce-shop.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/css/core/menu/menu-types/horizontal-menu.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('parent/assets/css/style.css')}}">
    <!-- END: Custom CSS-->

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @livewireStyles

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu 2-columns  navbar-sticky footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <div class="content-overlay"></div>
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-fixed navbar-brand-center">
        <div class="navbar-header d-xl-block d-none">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item">
                    <a class="navbar-brand" href="#">
                        <div class="brand-logo"></div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto">
                                <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                                    <i class="ficon feather icon-menu"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav bookmark-icons">
                            <li class="nav-item d-none d-lg-block">
                                <a class="nav-link" href="{{route('landing.page')}}" data-toggle="tooltip" data-placement="top" title="Go to Home Page">
                                    <img src="{{asset('storage/logo.png')}}" class="w-10 h-10" alt="">
                                </a>
                            </li>
                        </ul>
                        <ul class="lg:block nav navbar-nav">
                            <p class="text-blue-500 font-semibold">Miti Magazine</p>
                        </ul>
                    </div>

                    <ul class="nav navbar-nav float-right">
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link nav-link-expand">
                                <i class="ficon feather icon-maximize"></i>
                            </a>
                        </li>
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none">
                                    <span class="user-name text-bold-600">{{auth()->user()->name}}</span>
                                    <span class="text-blue-600 user-status">Online</span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{route('profile.show')}}"><i class="feather icon-user"></i> Edit Profile</a>
                                <a class="dropdown-item" href="#"><i class="feather icon-mail"></i> My Subscription</a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();"><i class="feather icon-power"></i> Logout
                                    </a>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="horizontal-menu-wrapper">
        <div class="header-navbar navbar-expand-sm navbar navbar-horizontal fixed-top navbar-light navbar-without-dd-arrow navbar-shadow menu-border" role="navigation" data-menu="menu-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mr-auto"><a class="navbar-brand" href="#">
                            <div class="brand-logo"></div>
                            <h2 class="brand-text mb-0">Miti Magazine</h2>
                        </a></li>
                    <li class="nav-item nav-toggle">
                        <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                            <i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
                            <i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Horizontal menu content-->
            <div class="navbar-container main-menu-content" data-menu="menu-container">
                <!-- include ../../../includes/mixins-->
                <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="fa fa-user"></i><span data-i18n="Starter kit">Manage Account</span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ (request()->is('user/profile')) ? 'active' : '' }}" data-menu=""><a class="dropdown-item" href="{{route('profile.show')}}" data-toggle="dropdown" data-i18n="Floating navbar">My profile</a>
                            </li>
                            <li class="{{ (request()->is('user/invites')) ? 'active' : '' }}" data-menu=""><a class="dropdown-item" href="{{route('user.invite')}}" data-toggle="dropdown" data-i18n="2 columns">Invite Others</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="#" data-toggle="dropdown" data-i18n="Fixed navbar">Payment methods</a>
                            </li>
                            <li class="{{ (request()->is('user/payments')) ? 'active' : '' }}" data-menu=""><a class="dropdown-item" href="{{route('user.payments')}}" data-toggle="dropdown" data-i18n="Fixed navbar">My payments and Invoices</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ (request()->is('user/MySubscription')) ? 'active' : '' }}"><a class="nav-link" href="{{route('user.subscriptions')}}"><i class="fa fa-newspaper-o"></i><span>My Subscription</span></a></li>
                    <li class="nav-item {{ (request()->is('user/MyOrders')) ? 'active' : '' }}"><a class="nav-link" href="{{route('user.orders')}}"><i class="feather icon-shopping-cart"></i><span>My orders</span></a></li>

                    @admin
                    <li class="nav-item {{ (request()->is('admin/Customers')) ? 'active' : '' }}"><a class="nav-link" href="{{route('customers.view')}}"><i class="fa fa-users"></i><span>Customers</span></a></li>
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="fa fa-money"></i><span data-i18n="Starter kit">Sales</span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown dropdown-submenu {{ (request()->is('admin/Paypal-payments')) || (request()->is('admin/Ipay-payments')) ? 'active' : '' }}" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown" data-i18n="Menu Levels">Payments</a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="{{route('paypal.admin')}}" data-toggle="dropdown" data-i18n="Second Level">Paypal</a>
                                    </li>
                                    <li data-menu=""><a class="dropdown-item" href="{{route('ipay.admin')}}" data-toggle="dropdown" data-i18n="Second Level">I-Pay</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown dropdown-submenu {{ (request()->is('admin/Cart-Orders')) || (request()->is('admin/Subscription-Orders')) ? 'active' : '' }}" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown" data-i18n="Menu Levels">Orders</a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="{{route('cart.orders')}}" data-toggle="dropdown" data-i18n="Second Level">Cart Orders</a>
                                    </li>
                                    <li data-menu=""><a class="dropdown-item" href="{{route('subscription.orders')}}" data-toggle="dropdown" data-i18n="Second Level">Subscription Orders</a>
                                    </li>
                                </ul>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="sk-layout-2-columns.html" data-toggle="dropdown" data-i18n="2 columns">Inventory</a>
                            </li>
                            <li class="{{ (request()->is('admin/gifts')) ? 'active' : '' }}" data-menu=""><a class="dropdown-item" href="{{route('admin.gift')}}" data-toggle="dropdown" data-i18n="2 columns">Gift Members</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="fa fa-cogs"></i><span data-i18n="Starter kit">System Administration</span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ (request()->is('admin/upload-magazine')) ? 'active' : '' }}" data-menu=""><a class="dropdown-item" href="{{route('upload.magazine')}}" data-toggle="dropdown" data-i18n="Floating navbar">Upload Magazine</a>
                            </li>
                            <li data-menu="" class="{{ (request()->is('admin/subscription-plans')) ? 'active' : '' }}"><a class="dropdown-item" href="{{route('manage.plans')}}" data-toggle="dropdown" data-i18n="Fixed navbar">Subscription Plans</a>
                            </li>
                            <li data-menu="" class="{{ (request()->is('admin/file-manager')) ? 'active' : '' }}"><a class="dropdown-item" href="{{route('manage.magazines')}}" data-toggle="dropdown" data-i18n="2 columns">Manage Magazines</a>
                            </li>
                        </ul>
                    </li>
                    @endadmin

                </ul>
            </div>
            <!-- /horizontal menu content-->
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="sk-layout-2-columns.html">{{Request::segment(1)}}</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="#">{{Request::segment(2)}}</a>
                                    </li>
                                    <!-- <li class="breadcrumb-item active">Fixed Navbar
                                    </li> -->
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">
                        <div class="dropdown">
                            <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-settings"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            @yield('content')
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light navbar-shadow">
        <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2021<a class="text-bold-800 grey darken-2" href="https://betterglobeforestry.com/" target="_blank">Better Globe Forestry,</a>All rights Reserved</span>
        </p>
    </footer>
    <!-- END: Footer-->

    @livewireScripts
    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('parent/app-assets/vendors/js/vendors.min.js')}}"></script>
    <script src="{{asset('parent/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('parent/app-assets/vendors/js/ui/jquery.sticky.js')}}"></script>
    <script src="{{asset('parent/app-assets/vendors/js/ui/prism.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('parent/app-assets/js/core/app-menu.js')}}"></script>
    <script src="{{asset('parent/app-assets/js/core/app.js')}}"></script>
    <script src="{{asset('parent/app-assets/js/scripts/components.js')}}"></script>
    <script src="{{asset('parent/app-assets/js/scripts/forms/select/form-select2.js')}}"></script>
    <script src="{{asset('parent/app-assets/js/scripts/pages/invoice.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('parent/app-assets/js/scripts/forms/form-tooltip-valid.js')}}"></script>
    <!-- BEGIN: Page JS-->
    <script src="{{asset('parent/app-assets/js/scripts/pages/app-ecommerce-shop.js')}}"></script>
    <!-- END: Page JS-->
    @yield('scripts')

</body>
<!-- END: Body-->

</html>