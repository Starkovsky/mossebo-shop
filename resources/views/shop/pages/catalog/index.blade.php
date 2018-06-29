@extends('shop.layouts.html')

@section('content')
    {{ Breadcrumbs::render('catalog') }}

    <div class="container">
        <h1 class="title-h1">
            {{ __('content.catalog') }}
        </h1>
    </div>

    @include('shop.layouts.structure', [
        'chunkName' => 'shop.chunks.structure-card',
        'items' => $items
    ])
@endsection
