@extends('shop.layouts.html')

@section('content')
    {{ Breadcrumbs::render('rooms') }}

    <div class="container">
        <h1 class="title-h1">
            {{ __('content.rooms') }}
        </h1>
    </div>

    @include('shop.layouts.structure', [
        'chunkName' => 'shop.chunks.structure-card',
        'items' => $items
    ])
@endsection
