@extends('layouts.html')

@section('title', config('app.name', 'Laravel'))

@section('meta-description', 'description main page')


@section('content')

    <div class="container my-3">
        <h1 class="title_h1">
            {{ $product->i18n->title }}
        </h1>
    </div>

    <div class="container my-2 block-ui">
        <div class="product-page">
            <div class="row">
                <div class="col-md-6 py-4 px-4">
                    <div class="slider slider-for zoom-gallery">
                        @foreach ($product->images as $image)
                            <a href="https://admin.mossebo.market{{ json_decode($image->pathes)->original }}"
                               title=""
                            >
                                <img
                                    data-lazy="https://admin.mossebo.market{{ json_decode($image->pathes)->medium->srcset }}"
                                    alt="">
                            </a>
                        @endforeach
                    </div>
                    <div class="slider slider-nav">
                        @foreach ($product->images as $image)
                            <div class="slider-nav__box">
                                <img
                                    data-lazy="https://admin.mossebo.market{{ json_decode($image->pathes)->thumb->src }}"
                                    alt="">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6 py-4 px-4 product-page__border-left">
                    <div class="product-page__actions text-right">
                        <a href="#"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="Добавить в сравнение"
                        >
                            <i class="md-icon">playlist_add</i>
                        </a>
                        <a href="#"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="Добавить в избранное"
                        >
                            <i class="md-icon">favorite</i>
                        </a>
                    </div>

                    <div class="product-page__price">144 144,14 &#8381;</div>
                    <div class="product-page__oldprice">155 155,15 &#8381;</div>
                    <div class="product-page__economy">Вы сэкономите: 8 000 &#8381;</div>

                    <div class="product-page__stars">
                        <i class="md-icon">star</i><i class="md-icon">star</i><i class="md-icon">star</i><i
                            class="md-icon">star_border</i><i class="md-icon">star_border</i>
                        <span>324 оценки об этом продукте</span>
                    </div>

                    <div class="product-page__label">Артикул:</div>
                    <div class="product-page__value">{{ $product->id }}</div>

                    <div class="product-page__label">Поставщик:</div>
                    <div class="product-page__value">{{ $product->supplier->name }}</div>

                    <div class="product-page__label">Срок поставки:</div>
                    <div class="product-page__value">Под заказ</div>

                    <div class="py-5">
                        <div class="row product-page__value">
                            <div class="col-sm-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 16">
                                    <path fill="#DFDFDF" fill-rule="evenodd" d="M7 0H1C.4 0 0 .4 0 1v2h3v2H0v2h3v2H0v2h3v2H0v2c0 .6.4 1 1 1h6c.6 0 1-.4 1-1V1c0-.6-.4-1-1-1z"/>
                                </svg>
                                {{ $product->width/10 }} см
                            </div>
                            <div class="col-sm-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 8">
                                    <path fill="#DFDFDF" fill-rule="evenodd" d="M11 0v3h2V0h2c.5522847 0 1 .4477152 1 1v6c0 .5522847-.4477153 1-1 1H1c-.5522847 0-1-.4477153-1-1V1c0-.5522848.4477153-1 1-1h2v3h2V0h2v3h2V0h2z"/>
                                </svg>
                                {{ $product->height/10 }} см
                            </div>
                            <div class="col-sm-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                    <path fill="#DFDFDF" fill-rule="evenodd" d="M15.7 4.3l-4-4c-.4-.4-1-.4-1.4 0L9 1.6l1.7 1.7-1.4 1.4L7.6 3 6 4.6l1.7 1.7-1.4 1.4L4.6 6 3 7.6l1.7 1.7-1.4 1.4L1.6 9 .3 10.3c-.4.4-.4 1 0 1.4l4 4c.4.4 1 .4 1.4 0l10-10c.4-.4.4-1 0-1.4z"/>
                                </svg>
                                {{ $product->length/10 }} см
                            </div>
                            <div class="col-sm-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 15">
                                    <path fill="#D8D8D8" d="M11 11.3V6c0-.8-.5-1.5-1.4-1.6H8.1V3c.6-.4 1-1 .9-1.6C8.9.5 8.2 0 7.2 0H3.3C2.6.2 2.1.7 2 1.5c0 .6.3 1.2.9 1.6v1.3H1.6C.6 4.4 0 5 0 5.9v7.6c0 .5.2 1 .6 1.2l.8.3h8.2c.8-.1 1.4-.8 1.4-1.7v-2z"/>
                                </svg>
                                {{ $product->weight/1000 }} кг
                            </div>
                        </div>
                    </div>


                    <div class="product-page__buttons">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group mb-3"
                                     data-toggle="tooltip"
                                     data-placement="top"
                                     title="Количество">
                                    <div class="input-group-prepend">
                                        <button class="button button-light" type="button">
                                            <i class="md-icon">add</i>
                                        </button>
                                    </div>
                                    <input type="text"
                                           class="form-control"
                                           placeholder=""
                                           aria-label=""
                                           aria-describedby="basic-addon1"
                                           value="1"
                                    >
                                    <div class="input-group-append">
                                        <button class="button button-light" type="button">
                                            <i class="md-icon">remove</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <button type="button"
                                        class="button button-light"
                                        data-toggle="modal"
                                        data-target="#exampleModal"
                                >
                                    Купить в 1 клик
                                </button>
                            </div>
                        </div>
                        {{--<button type="button"
                                class="button button-light"
                        >
                            <i class="md-icon">add_shopping_cart</i>
                            Добавить в корзину
                        </button>--}}
                    </div>

                    <div class="product-page__label">Поделиться:</div>
                    <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,gplus,twitter,viber,whatsapp,telegram" data-counter=""></div>

                </div>
            </div>
        </div>
    </div>


    <div class="container my-4 block-ui">
        <div class="product-page">

            <ul class="nav nav-tabs justify-content-center" id="ProductTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active"
                       id="home-tab"
                       data-toggle="tab"
                       href="#characteristic"
                       role="tab"
                       aria-controls="home"
                       aria-selected="true"
                    >
                        Описание и характеристики
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       id="profile-tab"
                       data-toggle="tab"
                       href="#review"
                       role="tab"
                       aria-controls="profile"
                       aria-selected="false"
                    >
                        Отзывы
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       id="contact-tab"
                       data-toggle="tab"
                       href="#instructions"
                       role="tab"
                       aria-controls="contact"
                       aria-selected="false"
                    >
                        Инструкции
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="ProductTabsContent">
                <div class="tab-pane fade show active"
                     id="characteristic"
                     role="tabpanel"
                     aria-labelledby="characteristic-tab"
                >
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            {{ $product->i18n->description }}
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade"
                     id="review"
                     role="tabpanel"
                     aria-labelledby="review-tab"
                >
                    <div class="product-page__under_constraction">
                        Данный раздел находится в разработке
                    </div>
                </div>
                <div class="tab-pane fade"
                     id="instructions"
                     role="tabpanel"
                     aria-labelledby="instructions-tab"
                >
                    <div class="product-page__under_constraction">
                        Данный раздел находится в разработке
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
