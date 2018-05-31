@extends('shop.layouts.html')

@section('title', config('app.name', 'Mossebo.Market'))

@section('meta-description', 'description main page')

@section('content')
    <div class="pt-5"></div>

    <div class="container">
        <checkout></checkout>
    </div>

    <div class="pb-5"></div>
@endsection
