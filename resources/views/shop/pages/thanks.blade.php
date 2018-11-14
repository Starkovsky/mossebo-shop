@extends('shop.layouts.html')

@section('content')
    <div class="container">
        <div class="checkout-thanks block-ui mt-48">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="title-h1">
                        Спасибо за заказ!
                    </h1>

                    <p class="checkout-thanks__text mb-32">
                        Скоро с вами свяжется менеджер Mossebo.Market.
                        Информация о заказе продублирована на вашу почту.
                    </p>

                    <div class="row">
                        <div class="col-sm-6 col-md-12 col-lg-6">
                            <a href="{{ siteUrl('catalog') }}" class="button button-primary button-long">
                                Продолжить покупки
                            </a>
                        </div>

                        <div class="col-sm-6 col-md-12 col-lg-6">
                            <a href="#" class="button button-primary button-long">
                                Узнать о скидках
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-60">
            <h2 class="title-h2">
                <a href="{{ settings('public-social-instagram') }}" target="_blank" rel="nofollow noreferrer noopener" class="instagram-title-link">
                    <img
                        src="/assets/images/icons/socials/instagram.png"
                        srcset="/assets/images/icons/socials/instagram@2x.png 2x"
                        alt="@mossebo.official"
                    >

                    @mossebo.official
                </a>
            </h2>

            <p class="mb-32">
                Следите за новинками Mossebo.Market в реальных интерьерах в нашем Instagram
            </p>

            <instagram
                profile="mossebo.official"
                :count="8"
            ></instagram>

            <div class="watch-all-btn-wrap mt-32">
                <a href="{{ settings('public-social-instagram') }}" class="watch-all-btn" target="_blank" rel="nofollow noreferrer noopener">
                    <span class="watch-all-btn__label">
                        Смотреть все
                    </span>

                    <span class="watch-all-btn__icon-box">
                        <svg class="watch-all-btn__icon">
                            <use xlink:href="/assets/images/icons.svg#symbol-arrow-forward"></use>
                        </svg>
                    </span>
                </a>
            </div>
        </div>

        <div class="mt-60 ">
            <div class="tabs-content block-ui">
                <div class="tabs-content__tabs">
                    <tabs-html
                        :tabs="{'#delivery': 'Доставка', '#pay': 'Оплата', '#garant': 'Гарантия возврата'}"
                        :class-name-modificators="['xl', 'underline', 'large-padding']"
                    ></tabs-html>
                </div>

                <div class="tabs-content__content">
                    <div class="tabs-content__pane tab-pane block-ui fade show active" id="delivery">
                        <div class="tab-pane__head js-ht-tab-trigger">
                            Доставка

                            <svg class="tab-pane__chevron">
                                <use xlink:href="/assets/images/icons.svg#symbol-chevron-down"></use>
                            </svg>
                        </div>

                        <div class="tab-pane__container ht-container">
                            <div class="tab-pane__inner ht-inner">
                                <div class="product-page__pane-help ht-inner">
                                    @foreach ($delivery as $item)
                                        <div class="help-block">
                                            <h2 class="help-block__title title-h3">
                                                {{ $item->title }}
                                            </h2>

                                            <div class="help-block__content">
                                                <div class="article">
                                                    {!! $item->content !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tabs-content__pane tab-pane block-ui fade" id="pay">
                        <div class="tab-pane__head js-ht-tab-trigger">
                            Оплата

                            <svg class="tab-pane__chevron">
                                <use xlink:href="/assets/images/icons.svg#symbol-chevron-down"></use>
                            </svg>
                        </div>

                        <div class="tab-pane__container ht-container">
                            <div class="tab-pane__inner ht-inner">
                                <div class="product-page__pane-help ht-inner">
                                    @foreach ($pay as $item)
                                        <div class="help-block">
                                            <h2 class="help-block__title title-h3">
                                                {{ $item->title }}
                                            </h2>

                                            <div class="help-block__content">
                                                <div class="article">
                                                    {!! $item->content !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tabs-content__pane tab-pane block-ui fade" id="garant">
                        <div class="tab-pane__head js-ht-tab-trigger">
                            Гарантия и возврат

                            <svg class="tab-pane__chevron">
                                <use xlink:href="/assets/images/icons.svg#symbol-chevron-down"></use>
                            </svg>
                        </div>

                        <div class="tab-pane__container ht-container">
                            <div class="tab-pane__inner ht-inner">
                                <div class="product-page__pane-help ht-inner">
                                    @foreach ($garant as $item)
                                        <div class="help-block">
                                            <h2 class="help-block__title title-h3">
                                                {{ $item->title }}
                                            </h2>

                                            <div class="help-block__content">
                                                <div class="article">
                                                    {!! $item->content !!}
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
        </div>
    </div>
@endsection
