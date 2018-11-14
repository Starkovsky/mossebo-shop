@extends('shop.layouts.html')

@section('content')
    {{ Breadcrumbs::render('style-catalog', $style, $category) }}

    <div class="container">
        <h1 class="title-h1">
            @if ($category)
                {{ $category->title }}
            @else
                {{ $style->title }}
            @endif
        </h1>
    </div>

    @include('shop.layouts.structure-popular', [
        'items' => $categories
    ])

    <div class="container mt-60">
        <catalog></catalog>
    </div>
@endsection
