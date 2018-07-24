@extends('shop.layouts.html')

@section('content')
    {{ Breadcrumbs::render('lk') }}

    <div class="container">
        <h1 class="title-h1">
            {{ __('lk.title') }}
        </h1>
    </div>

    <div class="container">
        <cabinet
            class="block-ui"
        ></cabinet>
    </div>
@endsection
