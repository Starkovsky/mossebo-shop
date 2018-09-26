@extends('shop.layouts.html')

@section('content')
    {{ Breadcrumbs::render('room-category', $room, $category) }}

    <div class="container">
        <h1 class="title-h1">
            {{ $category->title }}
        </h1>
    </div>

    <div class="container">
        <catalog></catalog>
    </div>
@endsection
