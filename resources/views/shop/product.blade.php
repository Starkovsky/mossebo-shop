@extends('layouts.html')

@section('title', config('app.name', 'Laravel'))

@section('meta-description', 'description main page')


@section('content')

    <div class="container my-4">
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
                            <svg class="symbol-icon symbol-wishlist">
                                <use xlink:href="/assets/images/icons.svg#symbol-wishlist"></use>
                            </svg>
                        </a>
                        <a href="#"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="Добавить в избранное"
                        >
                            <svg class="symbol-icon symbol-heart">
                                <use xlink:href="/assets/images/icons.svg#symbol-heart"></use>
                            </svg>
                        </a>
                    </div>

                    <div class="product-page__price">{{ $product->prices[0]->value/100 }} &#8381;</div>
                    <div class="product-page__oldprice"></div>
                    <div class="product-page__economy">Вы сэкономите: 8 000 &#8381;</div>

                    <div class="product-page__stars">
                        <div class="product-page__stars-box">
                            <svg class="symbol-icon product-rating">
                                <use xlink:href="/assets/images/icons.svg#product-rating"></use>
                            </svg>
                            <div class="product-page__stars-inner"></div>
                        </div>
                        <span>324 оценки об этом продукте</span>
                    </div>

                    <div class="product-page__label">Артикул:</div>
                    <div class="product-page__value">{{ $product->id }}</div>

                    <div class="product-page__label">Поставщик:</div>
                    <div class="product-page__value">{{ $product->supplier->name }}</div>

                    <div class="product-page__label">Срок поставки:</div>
                    <div class="product-page__value">Под заказ</div>

                    <div class="py-0">
                        <div class="row product-page__value">
                            <div class="col-sm-3">
                                <svg class="symbol-icon symbol-width">
                                    <use xlink:href="/assets/images/icons.svg#symbol-width"></use>
                                </svg>
                                {{ $product->width/10 }} см
                            </div>
                            <div class="col-sm-3">
                                <svg class="symbol-icon symbol-height">
                                    <use xlink:href="/assets/images/icons.svg#symbol-height"></use>
                                </svg>
                                {{ $product->height/10 }} см
                            </div>
                            <div class="col-sm-3">
                                <svg class="symbol-icon symbol-length">
                                    <use xlink:href="/assets/images/icons.svg#symbol-length"></use>
                                </svg>
                                {{ $product->length/10 }} см
                            </div>
                            <div class="col-sm-3">
                                <svg class="symbol-icon symbol-weight">
                                    <use xlink:href="/assets/images/icons.svg#symbol-weight"></use>
                                </svg>
                                {{ $product->weight/1000 }} кг
                            </div>
                        </div>
                    </div>


                    <div class="product-page__buttons py-3">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="input-group mb-3"
                                     data-toggle="tooltip"
                                     data-placement="top"
                                     title="Количество">
                                    <div class="input-group-prepend">
                                        <button class="button button-light" type="button">
                                            <svg class="symbol-icon symbol-remove">
                                                <use xlink:href="/assets/images/icons.svg#symbol-remove"></use>
                                            </svg>
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
                                            <svg class="symbol-icon symbol-add">
                                                <use xlink:href="/assets/images/icons.svg#symbol-add"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
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
