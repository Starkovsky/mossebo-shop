<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    @include('layouts.meta')

    <link rel="stylesheet" href="{{ mix('assets/css/app.css') }}" media="all">
    <link rel="stylesheet" href="{{ url('assets/css/montserrat.css') }}" media="all">

</head>
<body>

<div id="app">

    <scroll-bar></scroll-bar>

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
