@extends('shop.layouts.html')

@section('title', config('app.name', 'Laravel'))

@section('meta-description', 'description main page')


@section('content')

    <div class="container mb-4">
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

                    <div class="product-page__price">
                        <formatted-price :price="{{ $product->current_price->value }}"></formatted-price>
                    </div>
                    @if(isset($product->old_price))
                        <div class="product-page__oldprice">
                            <formatted-price :price="{{ $product->old_price->value }}"></formatted-price>
                        </div>
                        <div class="product-page__economy">
                            Вы сэкономите:
                            <formatted-price
                                :price="{{ $product->old_price->value - $product->current_price->value }}"
                            >
                            </formatted-price>
                        </div>
                    @else
                        <div class="product-page__economy"></div>
                    @endif
                    <div class="product-page__stars">
                        <div class="product-page__stars-box">
                            <svg class="product-rating">
                                <use xlink:href="/assets/images/icons.svg#product-rating"></use>
                            </svg>

                            <div class="product-page__stars-inner"></div>
                        </div>

                        <span>324 оценки об этом продукте</span>
                    </div>

                    <div class="product-page-attribute mb-2">
                        Артикул:
                        <span class="product-page-option">{{ $product->id }}</span>
                    </div>

                    <div class="mb-2">
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

                    <div class="product-page-attribute">
                        Наличие:
                        <span class="product-page-option">Под заказ</span>
                    </div>
                    <div class="product-page-attribute mb-5">
                        Срок поставки:
                        <span class="product-page-option">14 дней</span>
                    </div>

                    <div class="mb-5">
                        <div class="row">
                            <div class="col-md-3 d-flex align-items-center">
                                <span>Количество:</span>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group"
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
                            <div class="col-md-4"></div>
                        </div>
                    </div>


                    <div class="product-page__buttons py-3">
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="button"
                                        class="button button-dark"
                                        data-toggle="modal"
                                        data-target="#exampleModal"
                                >
                                    Купить в 1 клик
                                </button>
                            </div>
                            <div class="col-sm-6">
                                <button type="button"
                                        class="button button-primary"
                                >
                                    Добавить в корзину
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

                    <div class="product-page__label">
                        Расскажите друзьям:
                        <!-- uSocial -->
                        <div class="uSocial-Share" data-pid="7dcb3e6a17ce539277db2193d1b2a7da" data-type="share"
                             data-options="round,style4,default,absolute,horizontal,size32,counter0"
                             data-social="vk,ok,fb,pinterest,twi,telegram" data-mobile="vi,wa,sms"></div>
                        <!-- /uSocial -->
                    </div>
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
                        <div class="col-md-6">

                            @foreach($product->attributes as $attribute)
                                <div class="product-page-attribute">
                                    {{ $attribute->i18n->title }}:
                                    @foreach($product->attribute_options as $option)
                                        @if($option->attribute_id == $attribute->id)
                                            <span class="product-page-option">{{ $option->i18n->value }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach

                        </div>
                        <div class="col-md-6">
                            {!! $product->i18n->description !!}
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
