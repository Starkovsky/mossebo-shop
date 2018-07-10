@extends('shop.layouts.html')

@section('content')
    {{ Breadcrumbs::render('style-catalog', $style, $category) }}

    <div class="container">
        <h1 class="title-h1">
            @if ($category)
                {{ $category->currentI18n->title }}
            @else
                {{ $style->currentI18n->title }}
            @endif
        </h1>
    </div>

    @include('shop.layouts.structure', [
        'chunkName' => 'shop.chunks.structure-card',
        'items' => $categories
    ])
@endsection
