@extends('shop.layouts.html')

@section('content')
    {{ Breadcrumbs::render('catalog-category', $category) }}

    <div class="container mb-4">
        <h1 class="title-h1">
            {{ $category->currentI18n->title }}
        </h1>
    </div>

    <div class="container">
        <catalog></catalog>
    </div>
@endsection
