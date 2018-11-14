@extends('shop.layouts.html')

@section('content')
    <div class="container">
        <h1 class="title-h1">
            {{ trans('search.title.empty') }}
        </h1>
    </div>

    <div class="container">
        <catalog-search></catalog-search>
    </div>
@endsection
