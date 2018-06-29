@extends('shop.layouts.html')

@section('content')
    {{ Breadcrumbs::render('room-catalog', $room, $category) }}

    <div class="container">
        <h1 class="title-h1">
            {{ $room->currentI18n->title }}
        </h1>
    </div>

    @include('shop.layouts.structure', [
        'chunkName' => 'shop.chunks.structure-card',
        'items' => $categories
    ])
@endsection