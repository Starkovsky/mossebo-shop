@extends('shop.layouts.html')

@section('content')
    <div class="container">
        <div class="error-404 block-ui">
            <div class="error-404__row row">
                <div class="col-md-4">
                    <div class="error-404__code">
                        404
                    </div>
                </div>

                <div class="col-md-8">
                    <h1 class="error-404__title title-h1">
                        {{ __('content.404.title') }}

                    </h1>

                    <div class="error-404__text">
                        <p>
                            {{ __('content.404.message') }}
                        </p>
                    </div>

                    <div class="error-404__button">
                        <a href="{{ siteUrl() }}" class="button button-primary button-icon">
                            <svg class="button__icon button__icon--left">
                                <use xlink:href="/assets/images/icons.svg#symbol-arrow-back"></use>
                            </svg>

                            {{ __('content.404.homepage') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
