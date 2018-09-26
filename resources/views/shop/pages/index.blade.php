@extends('shop.layouts.html')

@section('content')
    <section class="content-block">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-6">
                    <banner-slider
                        type="double"
                        place="2"
                        quantity="8"
                    ></banner-slider>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-6">
                    <product-sale></product-sale>
                </div>
            </div>
        </div>
    </section>

    <section class="content-block js-product-list-container">
        <div class="container">
            <product-list
                title="{{ __('pages/home.product_list_popular') }}"
                :url="'{{ apiUrl('goods/popular') }}'"
            ></product-list>
        </div>
    </section>

    <section class="content-block js-product-list-container">
        <div class="container">
            <product-list
                title="{{ __('pages/home.product_list_new') }}"
                :url="'{{ apiUrl('goods/new') }}'"
            ></product-list>
        </div>
    </section>

    <section class="content-block">
        <div class="container">
            <div class="row">

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
    </section>

    <section class="content-block">
        @include('shop.layouts.structure', [
            'chunkName' => 'shop.chunks.structure-card',
            'items' => app()->make(\App\Http\Controllers\Shop\RoomController::class)->all()
        ])
    </section>

    <section class="content-block">
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
    </section>

    <section class="instagram-slider">
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
    </section>

    <section class="social-group">
        <div class="container">
            <div class="title-h2">Узнавай об акциях и находи промокоды в наших соцсетях!</div>
            <div class="row">
                <div class="col-md-6 col-xl-4">
                    <!-- VK Widget -->
                    <div id="vk_groups"></div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fmossebodesign%2F&width=340&height=222&small_header=false&adapt_container_width=true&hide_cover=true&show_facepile=true&appId=2082740105281448" width="340" height="222" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div id="ok_group_widget"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
