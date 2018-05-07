@extends('shop.layouts.html')

@section('title', config('app.name', 'Mossebo.Market'))

@section('meta-description', 'description main page')

@section('content')

    <div class="container my-4">
        <h1 class="title_h1">
            {{ $category->i18n->title }}
        </h1>
    </div>

    <div class="container">
        <catalog></catalog>
    </div>
    <div class="py-2"></div>
@endsection