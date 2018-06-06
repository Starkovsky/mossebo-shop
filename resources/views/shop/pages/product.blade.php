@extends('shop.layouts.html')

@section('title', config('app.name', 'Laravel'))

@section('meta-description', 'description main page')

@section('scripts')
    <script>
        window.product = {
            id: {{ $product->id }},
            selectable: {!! $selectable !!}
        }
    </script>
@endsection

@section('content')

    <div class="container mb-4">
        <h1 class="title_h1">
            {{ $product->currentI18n->title }}
        </h1>
    </div>

    <div class="product-page">
        <div class="container my-2">
            <div class="block-ui container">
                <div class="row">
                    <div class="col-lg-6 py-4">
                        <div class="slider slider-product zoom-gallery js-product-slider">
                            @foreach ($product->images as $image)
                                <div>
                                    <a
                                        href="https://admin.mossebo.market{{ json_decode($image->pathes)->original }}"
                                        style="background-image: url(https://admin.mossebo.market{{ json_decode($image->pathes)->medium->srcset }})"
                                    ></a>
                                </div>
                            @endforeach
                        </div>
                        <div class="slider slider-nav">
                            @foreach ($product->images as $image)
                                <div
                                    class="slider-nav__box"
                                    style="background-image: url(https://admin.mossebo.market{{ json_decode($image->pathes)->thumb->src }})"
                                ></div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-6 product-page__right">
                        <div class="product-page__actions text-right">
                            <product-actions></product-actions>
                        </div>

                        <div class="product-page__price">
                            <formatted-price :value="{{ $product->currentPrice->getValue() }}"></formatted-price>
                        </div>

                        @if(isset($product->oldPrice))
                            <div class="product-page__oldprice">
                                <formatted-price :value="{{ $product->oldPrice->getValue() }}"></formatted-price>
                            </div>
                            <div class="product-page__economy">
                                Вы сэкономите:
                                <formatted-price
                                    :value="{{ $product->oldPrice->getValue() - $product->currentPrice->getValue() }}"
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

                        <div class="product-page__params mb-3">
                            <div class="row">
                                <div class="product-page__param">
                                    <div class="product-param">
                                        Артикул:
                                        <span class="product-param__value">{{ $product->id }}</span>
                                    </div>
                                </div>

                                <div class="product-page__param">
                                    <div class="product-param">
                                        Наличие:
                                        <span class="product-param__value">Под заказ</span>
                                    </div>
                                </div>

                                <div class="product-page__param">
                                    <div class="product-param">
                                        Срок поставки:
                                        <span class="product-param__value">14 дней</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-page__sizes">
                            <div class="row">
                                <div class="col-6 col-sm-3 col-md-6 col-lg-3 p-0">
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

                                <div class="col-6 col-sm-3 col-md-6 col-lg-3 p-0">
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

                                <div class="col-6 col-sm-3 col-md-6 col-lg-3 p-0">
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

                                <div class="col-6 col-sm-3 col-md-6 col-lg-3 p-0">
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

        <div class="container my-4">
            <div class="product-page__info block-ui">
                <div class="product-tabs">
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
                                            <div class="product-tabs-pane__under_constraction">
                                                Данный раздел находится в разработке
                                            </div>
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







@endsection
