@extends('shop.layouts.html')

@section('content')
    {{ Breadcrumbs::render('help-article', $article) }}

    <div class="container">
        <h1 class="title-h1">
            {{ $article->title }}
        </h1>
    </div>

    <div class="help-article-page">
        <div class="container">
            <div class="content-w-menu block-ui">
                <div class="row row--no-padding">
                    <div class="d-none d-lg-block col-lg-4">
                        <div class="content-w-menu__menu">
                            @include('shop.layouts.help-sub-nav')
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="content-w-menu__content">
                            @foreach ($items as $item)
                                <div class="content-w-menu__item">
                                    <div class="help-item">
                                        <h2 class="help-item__title title-h3">
                                            {{ $item->title }}
                                        </h2>

                                        <div class="help-item__content">
                                            <div class="article">
                                                {!! $item->content !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
