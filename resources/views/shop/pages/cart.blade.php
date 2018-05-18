@extends('shop.layouts.html')

@section('title', config('app.name', 'Mossebo.Market'))

@section('meta-description', 'description main page')

@section('content')
    <div class="container mb-4">
        <h1 class="title_h1">
            Корзина
        </h1>
    </div>

    <div class="container">
        <cart></cart>
    </div>
    <div class="py-2"></div>
@endsection
