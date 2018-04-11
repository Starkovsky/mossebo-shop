<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    @include('layouts.meta')

    <!--[if IE]>
    <link rel="stylesheet" href="{{ mix('assets/css/app.css') }}">
    <![endif]-->

</head>
<body>

    <!--[if !IE]> -->
    <link rel="stylesheet" href="{{ mix('assets/css/app.css') }}" lazyload>
    <!-- <![endif]-->

<div id="app">

    @include('layouts.header')
    @include('layouts.nav')

    @yield('content')

    @include('layouts.footer')

</div>

<script src="{{ mix('assets/js/manifest.js') }}" defer></script>
<script src="{{ mix('assets/js/vendor.js') }}" defer></script>
<script src="{{ mix('assets/js/app.js') }}" defer></script>

@include('layouts.metrika')

</body>
</html>
