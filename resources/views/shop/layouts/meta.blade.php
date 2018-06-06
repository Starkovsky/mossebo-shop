<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

{{-- CSRF Token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title')</title>

<meta name="description" content="@yield('meta-description')">

{{-- Disable automatic detection and formatting of possible phone numbers --}}
<meta name="format-detection" content="telephone=no">

{{-- Icon in the highest resolution we need it for --}}
<link rel="icon" sizes="192x192" href="/favicon.png">
{{-- Apple Touch Icon (reuse 192px icon.png) --}}
<link rel="apple-touch-icon" href="/favicon.png">

<meta name="theme-color" content="#fcc600"/>
