@extends('shop.layouts.html')

@section('content')
    <main class="content-block">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <banner-home-stock></banner-home-stock>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <banner-home-new></banner-home-new>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-6">
                    <product-sale></product-sale>
                </div>

                <div class="col-md-4">
                    <a href="{{ route('help-article', ['slug' => 'delivery']) }}" class="information-block block-ui block-ui--with-hover">
                        <div class="information-block__title">Доставка</div>
                        Mossebo.Market доставляет товары по Москве и Санкт-Петербургу до порога вашей квартиры. Доставка в регионы согласуется отдельно.
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="{{ route('help-article', ['slug' => 'pay']) }}" class="information-block block-ui block-ui--with-hover">
                        <div class="information-block__title">Оплата</div>
                        Сейчас на сайте доступна оплата по расчетному счету, в ближайшее время все заказы можно будет оплатить картой, электронными кошельками и бонусами.
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="{{ route('help-article', ['slug' => 'garant']) }}" class="information-block block-ui block-ui--with-hover">
                        <div class="information-block__title">Гарантия</div>
                        Мы не только быстро доставляем,  но и без проблем возвращаем. В течение 14 дней без объяснения причин вы можете осуществить возврат товара.
                    </a>
                </div>
            </div>
        </div>
    </main>

    <main class="content-block js-product-list-container">
        <div class="container">
            <product-list
                title="{{ __('pages/home.product_list_popular') }}"
                :url="'{{ apiUrl('goods/popular') }}'"
            ></product-list>
        </div>
    </main>

    <main class="content-block js-product-list-container">
        <div class="container">
            <product-list
                title="{{ __('pages/home.product_list_new') }}"
                :url="'{{ apiUrl('goods/new') }}'"
            ></product-list>
        </div>
    </main>

    <main class="content-block">
        @include('shop.layouts.structure', [
            'chunkName' => 'shop.chunks.structure-card',
            'items' => app()->make(\App\Http\Controllers\Shop\RoomController::class)->all()
        ])
    </main>

    <main class="content-block">
        <div class="container">
            <h2 class="title-h2">Стили</h2>
        </div>

        @include('shop.layouts.structure', [
            'chunkName' => 'shop.chunks.structure-card',
            'items' => array_slice(app()->make(\App\Http\Controllers\Shop\StyleController::class)->all(), 0, 6)
        ])

        <div class="container">
            @include('chunks.buttons.watch-all', ['link' => siteUrl('/styles')])
        </div>
    </main>

    <div class="instagram-slider">
        <div class="overlay">
            <div class="container">
                <h3 class="title-h2">Наша продукция в реальных интерьерах</h3>
                <a
                    href="{{ settings('public-social-instagram') }}"
                    target="_blank"
                    class="button button-instagram"
                    rel="nofollow noreferrer noopener"
                >
                    Instagram
                    <svg class="symbol-icon symbol-arrow-forward">
                        <use xlink:href="/assets/images/icons.svg#symbol-arrow-forward"></use>
                    </svg>
                </a>
            </div>
            <div class="instagram-overlay-svg"></div>
        </div>
        <div class="slider slider-instagram">
            <div style="background-image: url(/assets/images/instagram-slider/1.jpg);"
                 class="instagram-slider__image"
            >
            </div>
            <div style="background-image: url(/assets/images/instagram-slider/2.jpg);"
                 class="instagram-slider__image"
            >
            </div>
            <div style="background-image: url(/assets/images/instagram-slider/3.jpg);"
                 class="instagram-slider__image"
            >
            </div>
            <div style="background-image: url(/assets/images/instagram-slider/4.jpg);"
                 class="instagram-slider__image"
            >
            </div>
        </div>
    </div>
@endsection
