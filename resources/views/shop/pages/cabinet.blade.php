@extends('shop.layouts.html')

@section('content')
    {{ Breadcrumbs::render('cabinet') }}

    <div class="container">
        <h1 class="title-h1">
            {{ __('content.cabinet') }}
        </h1>
    </div>

    <div class="container">
        <cabinet
            class="block-ui"
        ></cabinet>
    </div>
@endsection
