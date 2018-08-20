@extends('shop.layouts.html')

@section('content')
    <div class="container">
        <div class="error-404 block-ui">
            <div class="error-404__info">
                <h1 class="error-404__title title-h1">
                    {{ __('content.404.title') }}
                </h1>

                <div class="error-404__image-wrap">
                    <img class="error-404__image" src="/assets/images/404.png" alt="{{ __('content.404.title') }}">
                </div>

                <div class="error-404__text">

                    <div class="article">
                        <p>
                            Приносим извинения, страница не существовала или была удалена.
                        </p>

                        <p>
                            Возможно вам помогут эти ссылки:
                        </p>
                    </div>

                </div>
            </div>

            <div class="error-404__controls">
                <div class="row justify-content-center">
                    <div class="error-404__control">
                        <a href="{{ siteUrl('/catalog') }}" class="button button-primary button-long">
                            Выбрать товар
                        </a>
                    </div>

                    @php
                        // доделать бейджик с количеством существующих акций
                    @endphp

                    <div class="error-404__control">
                        <a href="{{ siteUrl('/#') }}" class="button button-primary button-long">
                            Скидки и акции
                        </a>
                    </div>

                    <div class="error-404__control error-404__control--search">
                        <search-input
                            placeholder="Найти подходящий товар"
                        ></search-input>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
