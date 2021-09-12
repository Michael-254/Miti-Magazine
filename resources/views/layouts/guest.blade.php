<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Miti Magazine | Better Globe Forestry LTD</title>
    <link rel="apple-touch-icon" href="{{asset('/storage/logo.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/storage/logo.png')}}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <link rel="apple-touch-icon" href="app-assets/images/logo/logo.png">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/logo/logo.png">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/vendors/css/ui/prism.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('parent/app-assets/css/core/menu/menu-types/horizontal-menu.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{('parent/assets/css/style.css')}}">
    <!-- END: Custom CSS-->
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
    <div class="font-sans font-bold antialiased">
        {{ $slot }}
    </div>

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
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <!-- END: Page JS-->
</body>

</html>