<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    @include('shop.layouts.meta')

    <link rel="stylesheet" href="{{ mix('assets/css/app.css') }}" media="all">
    {{--<link rel="stylesheet" href="{{ url('assets/css/montserrat.css') }}" media="all">--}}
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500&amp;subset=cyrillic-ext" rel="stylesheet">

</head>
<body>

<div id="app">

    <scroll-bar></scroll-bar>

    @include('shop.layouts.header')
    @include('shop.layouts.nav')

    @include('shop.layouts.breadcrumbs')

    @yield('content')

    @include('shop.layouts.footer')

</div>

@include('shop.layouts.shop_config')

<script src="{{ mix('assets/js/manifest.js') }}" defer></script>
<script src="{{ mix('assets/js/vendor.js') }}" defer></script>
<script src="{{ mix('assets/js/app.js') }}" defer></script>


@include('shop.layouts.metrika')

</body>
</html>
