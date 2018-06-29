@extends('shop.layouts.html')

@section('content')
    {{ Breadcrumbs::render('cabinet') }}

    <div class="container">
        <h1 class="title-h1">
            {{ __('content.catalog') }}
        </h1>
    </div>

    <div class="container">
        <catalog
            class="block-ui"
        ></catalog>
    </div>
@endsection
