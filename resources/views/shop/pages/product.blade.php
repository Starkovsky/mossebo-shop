@extends('shop.layouts.html')

@section('scripts')
    <script>
        window.product = {
            id: {{ $product->id }},
            selectable: {!! $selectable !!}
        }
    </script>
@endsection

@section('content')
    @php
        $images = array_map(function($image) {
            return json_decode($image['pathes']);
        }, $product->images->toArray());

        $imagesCount = count($images);
    @endphp

    {{ Breadcrumbs::render('good', $product) }}

    <div class="product-page">
        <div class="container">
            <h1 class="title-h1">
                {{ $product->currentI18n->title }}
            </h1>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product-page__block block-ui">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="product-page__left">
                                    @if ($imagesCount > 1)
                                        <div class="slider slider-product js-zoom-gallery js-product-slider">
                                            @foreach ($images as $image)
                                                <div class="slider-product__slide">
                                                    <a
                                                        href="https://admin.mossebo.market{{ $image->original }}"
                                                        data-fancybox="gallery"
                                                    >
                                                        <div
                                                            class="produt-page-image product-image bg-image"
                                                            style="background-image: url(https://admin.mossebo.market{{ $image->medium->srcset }})"
                                                        ></div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="slider slider-nav mt-24">
                                            @foreach ($images as $image)
                                                <div
                                                    class="slider-nav__box product-image bg-image"
                                                    style="background-image: url(https://admin.mossebo.market{{ $image->thumb->srcset }})"
                                                ></div>
                                            @endforeach
                                        </div>
                                    @elseif ($imagesCount === 1)
                                        <div>
                                            <a
                                                href="https://admin.mossebo.market{{ $images[0]->original }}"
                                                data-fancybox
                                            >
                                                <div
                                                    class="produt-page-image product-image bg-image"
                                                    style="background-image: url(https://admin.mossebo.market{{ $images[0]->medium->srcset }})"
                                                ></div>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 product-page__border">
                                <div class="product-page__right">
                                    <div class="product-page__actions text-right">
                                        <product-actions></product-actions>
                                    </div>

                                    <div class="product-page__price">
                                        <formatted-price :value="{{ $product->currentPrice->value }}"></formatted-price>
                                    </div>

                                    @if(isset($product->oldPrice))
                                        <div class="product-page__oldprice">
                                            <formatted-price :value="{{ $product->oldPrice->value }}"></formatted-price>
                                        </div>
                                        <div class="product-page__economy">
                                            Вы сэкономите:
                                            <formatted-price
                                                :value="{{ $product->oldPrice->value - $product->currentPrice->value }}"
                                            >
                                            </formatted-price>
                                        </div>
                                    @else
                                        <div class="product-page__economy"></div>
                                    @endif

                                    <div class="product-page__stars">
                                        <rating
                                            class-name-modificators="lg"
                                        ></rating>
                                    </div>

                                    <div class="product-page__params">
                                        <div class="row row--no-v">
                                            <div class="product-page__param">
                                                <div class="product-param">
                                                    Артикул:
                                                    <span class="product-param__value">
                                                        {{ $product->id }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="product-page__param">
                                                <div class="product-param">
                                                    Наличие:
                                                    <span class="product-param__value">
                                                        Под заказ
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="product-page__param">
                                                <div class="product-param">
                                                    Срок поставки:
                                                    <span class="product-param__value">
                                                        14 дней
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-page__sizes">
                                        <div class="row row--no-padding">
                                            <div class="col-6 col-sm-3 col-md-6 col-lg-3">
                                                <div class="product-page__size">
                                                    <div class="product-size">
                                                        <svg class="product-size__icon">
                                                            <use xlink:href="/assets/images/icons.svg#symbol-width"></use>
                                                        </svg>

                                                        <span class="product-size__value">
                                                            {{ $product->width/10 }} см
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6 col-sm-3 col-md-6 col-lg-3">
                                                <div class="product-page__size">
                                                    <div class="product-size">
                                                        <svg class="product-size__icon">
                                                            <use xlink:href="/assets/images/icons.svg#symbol-height"></use>
                                                        </svg>

                                                        <span class="product-size__value">
                                                            {{ $product->height/10 }} см
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6 col-sm-3 col-md-6 col-lg-3">
                                                <div class="product-page__size">
                                                    <div class="product-size">
                                                        <svg class="product-size__icon">
                                                            <use xlink:href="/assets/images/icons.svg#symbol-length"></use>
                                                        </svg>

                                                        <span class="product-size__value">
                                                            {{ $product->length/10 }} см
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6 col-sm-3 col-md-6 col-lg-3">
                                                <div class="product-page__size">
                                                    <div class="product-size">
                                                        <svg class="product-size__icon">
                                                            <use xlink:href="/assets/images/icons.svg#symbol-weight"></use>
                                                        </svg>

                                                        <span class="product-size__value">
                                                            {{ $product->weight/1000 }} кг
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-page__controls">
                                        <product-controls></product-controls>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="product-page__block product-page__info block-ui">
                        <div class="product-tabs js-product-tabs">
                            <div class="product-tabs__tabs">
                                <tabs-html
                                    :tabs="{'#characteristics': 'Описание и характеристики', '#reviews': 'Отзывы', '#instructions': 'Инструкции'}"
                                    :class-name-modificators="['center', 'xl', 'underline']"
                                ></tabs-html>
                            </div>

                            <div class="product-tabs__content">
                                <div class="tab-content">
                                    <div class="product-tabs__pane tab-pane block-ui fade show active" id="characteristics">
                                        <div class="product-tabs-pane">
                                            <div class="product-tabs-pane__trigger js-ht-product-info">
                                                Характеристики

                                                <svg class="product-tabs-pane__chevron">
                                                    <use xlink:href="/assets/images/icons.svg#symbol-chevron-down"></use>
                                                </svg>
                                            </div>

                                            <div class="product-tabs-pane__content ht-container">
                                                <div class="product-tabs-pane__inner ht-inner">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="product-tabs-pane__attributes">
                                                                @foreach($attributes as $attribute)
                                                                    @php
                                                                        $optionsAsString = $product->attributeOptions->reduce(function ($carry, $option) use($attribute) {
                                                                            if ($option->attribute_id == $attribute->id) {
                                                                                $carry[] = $option->currentI18n->value;
                                                                            }

                                                                            return $carry;
                                                                        }, []);

                                                                        $optionsAsString = join(', ', $optionsAsString);
                                                                    @endphp

                                                                    @if ($optionsAsString)
                                                                        <div class="product-param">
                                                                            {{ $attribute->currentI18n->title }}:

                                                                            <span class="product-param__value">
                                                                                {{ $optionsAsString }}
                                                                            </span>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="product-tabs-pane__description">
                                                                {!! $product->currentI18n->description !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-tabs__pane tab-pane block-ui fade" id="reviews">
                                        <div class="product-tabs-pane">
                                            <div class="product-tabs-pane__trigger js-ht-product-info">
                                                Отзывы

                                                <svg class="product-tabs-pane__chevron">
                                                    <use xlink:href="/assets/images/icons.svg#symbol-chevron-down"></use>
                                                </svg>
                                            </div>

                                            <div class="product-tabs-pane__content ht-container">
                                                <div class="product-tabs-pane__inner ht-inner">
                                                    <reviews url="{{ siteUrl('goods/' . $product->id . '/reviews') }}"></reviews>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-tabs__pane tab-pane block-ui fade" id="instructions">
                                        <div class="product-tabs-pane">
                                            <div class="product-tabs-pane__trigger js-ht-product-info">
                                                Доставка и возврат

                                                <svg class="product-tabs-pane__chevron">
                                                    <use xlink:href="/assets/images/icons.svg#symbol-chevron-down"></use>
                                                </svg>
                                            </div>

                                            <div class="product-tabs-pane__content ht-container">
                                                <div class="product-tabs-pane__inner ht-inner">
                                                    <div class="product-tabs-pane__under_constraction">
                                                        Данный раздел находится в разработке
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-60 js-product-list-container">
                <product-list
                    title="Похожие товары"
                    :url="'{{ apiUrl('goods/' . $product->id . '/similar') }}'"
                ></product-list>
            </div>

            <div class="col-12 mt-60 js-product-list-container">
                <product-list
                    title="Дополните комплект"
                    :url="'{{ apiUrl('goods/' . $product->id . '/related') }}'"
                ></product-list>
            </div>
        </div>
    </div>




    <div class="d-none">
        <div id="popup-one-click" class="popup animated zoomIn block-ui">
            <form class="js-form-sender" action="{{ siteUrl('forms/one-click') }}">
                <input type="hidden" name="id" value="{{ $product->id }}">

                <div class="popup__top">
                    <div class="popup__title title-h3">
                        Быстрый заказ
                    </div>

                    <div class="popup__desc">
                        Введите ваш телефон, и мы свяжемся с вами в течение нескольких минут для уточнения заказа.
                    </div>
                </div>

                <div class="popup__content">
                    @if($imagesCount > 0)
                        <div class="popup__image text-center">
                            <img
                                src="https://admin.mossebo.market{{ $images[0]->small->src }}"
                                srcset="https://admin.mossebo.market{{ $images[0]->small->srcset }} 2x"
                                alt="{{ $product->currentI18n->title }}">
                        </div>
                    @endif

                    <div class="popup__form">
                        <div class="form-group mt-24 js-form-group">
                            <label for="popup-one-click-phone" class="form-label">
                                Телефон
                            </label>

                            <input
                                id="popup-one-click-phone"
                                type="tel"
                                class="form-input"
                                name="phone"
                                minlength="6"
                                maxlength="255"
                                required
                            >
                        </div>
                    </div>
                </div>

                <div class="popup__bottom">
                    <div class="popup__button">
                        <button type="submit" class="button button-loading button-primary button-long">
                            <span class="button-loading__content">
                                Заказать
                            </span>

                            <svg class="button-loading__loader">
                                <use xlink:href="/assets/images/icons.svg#symbol-spinner"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
