@extends('shop.layouts.html')

@section('content')
    {{ Breadcrumbs::render('help') }}

    <div class="container">
        <h1 class="title-h1">
            {{ __('content.help') }}
        </h1>
    </div>

    <div class="help-page">
        <div class="container">
            <div class="help-page__content block-ui">
                @include('shop.layouts.help-sub-nav')
            </div>
        </div>
    </div>
@endsection
