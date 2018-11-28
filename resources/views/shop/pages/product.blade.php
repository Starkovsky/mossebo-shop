@extends('shop.layouts.html')

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
                {{ $product->title }}
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
                                                <div class="slider__slide slider-product__slide">
                                                    <a
                                                        href="{{ imagePath($image->original) }}"
                                                        data-fancybox="gallery"
                                                        class="image-preview-link"
                                                    >
                                                        <div class="image-preview-link__label">
                                                            <svg class="image-preview-link__icon">
                                                                <use xlink:href="/assets/images/icons.svg#symbol-zoom-in"></use>
                                                            </svg>

                                                            <span class="image-preview-link__text">
                                                                Увеличить фото
                                                            </span>
                                                        </div>

                                                        <div
                                                            class="product-page-image product-image bg-image"
                                                            style="background-image: url(https://admin.mossebo.market{{ $image->medium->srcset }})"
                                                        ></div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="slider slider-nav mt-24">
                                            @foreach ($images as $image)
                                                <div
                                                    class="slider__slide slider-nav__box product-image bg-image"
                                                    style="background-image: url({{ imagePath($image->thumb->srcset) }})"
                                                ></div>
                                            @endforeach
                                        </div>
                                    @elseif ($imagesCount === 1)
                                        <div>
                                            <a
                                                href="{{ imagePath($images[0]->original) }}"
                                                class="image-preview-link"
                                                data-fancybox
                                            >
                                                <div class="image-preview-link__label">
                                                    <svg class="image-preview-link__icon">
                                                        <use xlink:href="/assets/images/icons.svg#symbol-zoom-in"></use>
                                                    </svg>

                                                    <span class="image-preview-link__text">
                                                        Увеличить фото
                                                    </span>
                                                </div>

                                                <div
                                                    class="product-page-image product-image bg-image"
                                                    style="background-image: url(https://admin.mossebo.market{{ $images[0]->medium->srcset }})"
                                                ></div>
                                            </a>
                                        </div>
                                    @else
                                        <div>
                                            <div class="product-page-image product-image bg-image"></div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 product-page__border">
                                <div class="product-page__right">
                                    <product-controls
                                        :product="{{ json_encode($product, JSON_UNESCAPED_UNICODE) }}"
                                        :selectable="{{ $selectable }}"
                                    ></product-controls>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="tabs-content block-ui">
                        <div class="tabs-content__tabs">
                            <tabs-html
                                :tabs="{'#characteristics': 'Описание и характеристики', '#delivery': 'Доставка', '#pay': 'Оплата', '#garant': 'Гарантия возврата'}"
                                :class-name-modificators="['xl', 'underline', 'large-padding']"
                            ></tabs-html>
                        </div>

                        <div class="tabs-content__content">
                            <div class="tabs-content__pane tab-pane block-ui fade show active" id="characteristics">
                                <div class="tab-pane__head js-ht-tab-trigger">
                                    Характеристики

                                    <svg class="tab-pane__chevron">
                                        <use xlink:href="/assets/images/icons.svg#symbol-chevron-down"></use>
                                    </svg>
                                </div>

                                <div class="tab-pane__container ht-container">
                                    <div class="tab-pane__inner ht-inner">
                                        <div class="tab-pane__content">
                                            <div class="row row--half">
                                                <div class="col-lg-6">
                                                    <div class="product-page__pane-attributes">
                                                        @foreach($attributes as $attribute)
                                                            @php
                                                                $optionsAsString = $product->attributeOptions->reduce(function ($carry, $option) use($attribute) {
                                                                    if ($option->attribute_id == $attribute->id) {
                                                                        $carry[] = $option->value;
                                                                    }

                                                                    return $carry;
                                                                }, []);

                                                                $optionsAsString = join(', ', $optionsAsString);
                                                            @endphp

                                                            @if ($optionsAsString)
                                                                <div class="product-param">
                                                                    {{ $attribute->title }}:

                                                                    <span class="product-param__value">
                                                                    {{ $optionsAsString }}
                                                                </span>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="product-page__pane-description">
                                                        {!! str_replace(PHP_EOL, '<br>', $product->description) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tabs-content__pane tab-pane block-ui fade" id="delivery">
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

            <div class="col-12 mt-60">
                <h2 class="title-h2">
                    Отзывы покупателей
                </h2>

                <reviews
                    url="{{ siteUrl('goods/' . $product->id . '/reviews') }}"
                    title="{{ $product->title }}"
                ></reviews>
            </div>

            <div class="col-12 mt-60 js-product-list-container">
                <product-list
                    title="Дополните комплект"
                    :url="'{{ apiUrl('goods/' . $product->id . '/related') }}'"
                ></product-list>
            </div>

            <div class="col-12 mt-60 js-product-list-container">
                <product-list
                    title="Похожие товары"
                    :url="'{{ apiUrl('goods/' . $product->id . '/similar') }}'"
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
                                alt="{{ $product->title }}">
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
