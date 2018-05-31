@extends('shop.layouts.html')

@section('title', config('app.name', 'Laravel'))

@section('meta-description', 'description main page')


@section('content')
    <div class="container mb-2">
        <h1 class="title_h1">
            Комнаты
        </h1>
    </div>

    <div class="container mb-3 mb-md-5">

        @include('shop.chunks.rooms_chunk')

    </div>
@endsection
