@extends('shop.layouts.html')

@section('content')
    {{ Breadcrumbs::render('style-category', $style, $category) }}

    <div class="container">
        <h1 class="title-h1">
            {{ $style->currentI18n->title }}
        </h1>
    </div>

    <div class="container">
        <catalog></catalog>
    </div>
@endsection
