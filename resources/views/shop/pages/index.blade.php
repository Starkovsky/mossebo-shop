@extends('shop.layouts.html')

@section('title', config('app.name', 'Laravel'))

@section('meta-description', 'description main page')

@section('content')
    <div class="container">
        <main class="header__title d-none">
            <h1 class="title_h1">
                {{ __('layouts.mossebo-header-name') }}
                <br>
                {{ config('app.name', 'Laravel') }}
            </h1>
        </main>



        <main class="py-4">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <banner-home-stock></banner-home-stock>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <banner-home-new></banner-home-new>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-6">
                    <product-card
                        :product="ActionProduct"
                    >
                    </product-card>
                </div>
            </div>
        </main>

        <main class="py-4">
            <div class="row align-items-stretch">
                <div class="col-md-4">
                    <div class="information-block">
                        <div class="information-block__title">Доставка</div>
                        Mossebo.Market доставляет товары по Москве и Санкт-Петербургу до порога вашей квартиры. Доставка в регионы согласуется отдельно.
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="information-block">
                        <div class="information-block__title">Оплата</div>
                        Сейчас на сайте доступна оплата по расчетному счету, в ближайшее время все заказы можно будет оплатить картой, электронными кошельками и бонусами.
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="information-block">
                        <div class="information-block__title">Гарантия</div>
                        Мы не только быстро доставляем,  но и без проблем возвращаем. В течение 14 дней без объяснения причин вы можете осуществить возврат товара.
                    </div>
                </div>
            </div>
        </main>


        <main class="py-4">
            <h2 class="title_h2">{{ __('pages/home.product_list_new') }}</h2>
            <product-list
            >
            </product-list>
        </main>


        <main class="py-4 interior_styles">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a class="interior_styles__item"
                       href="#"
                    >
                        <div class="interior_styles__item-image-box">
                            <div class="interior_styles__item-image"
                                 style="background-image: url('/assets/images/u-blocks/interier-styles/1.jpg');"
                            >
                            </div>
                        </div>
                        <div class="interior_styles__item-description">
                            <div class="interior_styles__item-name">
                                Гостиная
                            </div>
                            <div class="interior_styles__item-amount">
                                Более 4 000 товаров
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a class="interior_styles__item"
                       href="#"
                    >
                        <div class="interior_styles__item-image-box">
                            <div class="interior_styles__item-image"
                                 style="background-image: url('/assets/images/u-blocks/interier-styles/2.jpg');"
                            >
                            </div>
                        </div>
                        <div class="interior_styles__item-description">
                            <div class="interior_styles__item-name">
                                Кабинет
                            </div>
                            <div class="interior_styles__item-amount">
                                Более 25 000 товаров
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a class="interior_styles__item"
                       href="#"
                    >
                        <div class="interior_styles__item-image-box">
                            <div class="interior_styles__item-image"
                                 style="background-image: url('/assets/images/u-blocks/interier-styles/3.jpg');"
                            >
                            </div>
                        </div>
                        <div class="interior_styles__item-description">
                            <div class="interior_styles__item-name">
                                Детская
                            </div>
                            <div class="interior_styles__item-amount">
                                Более 6 000 товаров
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <a class="interior_styles__item"
                       href="#"
                    >
                        <div class="interior_styles__item-image-box">
                            <div class="interior_styles__item-image"
                                 style="background-image: url('/assets/images/u-blocks/interier-styles/4.jpg');"
                            >
                            </div>
                        </div>
                        <div class="interior_styles__item-description">
                            <div class="interior_styles__item-name">
                                Столовая и кухня
                            </div>
                            <div class="interior_styles__item-amount">
                                Более 3 300 товаров
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <a class="interior_styles__item"
                       href="#"
                    >
                        <div class="interior_styles__item-image-box">
                            <div class="interior_styles__item-image"
                                 style="background-image: url('/assets/images/u-blocks/interier-styles/5.jpg');"
                            >
                            </div>
                        </div>
                        <div class="interior_styles__item-description">
                            <div class="interior_styles__item-name">
                                Спальня
                            </div>
                            <div class="interior_styles__item-amount">
                                Более 8 400 товаров
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a class="interior_styles__item"
                       href="#"
                    >
                        <div class="interior_styles__item-image-box">
                            <div class="interior_styles__item-image"
                                 style="background-image: url('/assets/images/u-blocks/interier-styles/6.jpg');"
                            >
                            </div>
                        </div>
                        <div class="interior_styles__item-description">
                            <div class="interior_styles__item-name">
                                Прихожая
                            </div>
                            <div class="interior_styles__item-amount">
                                Более 3 500 товаров
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a class="interior_styles__item"
                       href="#"
                    >
                        <div class="interior_styles__item-image-box">
                            <div class="interior_styles__item-image"
                                 style="background-image: url('/assets/images/u-blocks/interier-styles/6.jpg');"
                            >
                            </div>
                        </div>
                        <div class="interior_styles__item-description">
                            <div class="interior_styles__item-name">
                                Ванная
                            </div>
                            <div class="interior_styles__item-amount">
                                Более 3 500 товаров
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a class="interior_styles__item"
                       href="#"
                    >
                        <div class="interior_styles__item-image-box">
                            <div class="interior_styles__item-image"
                                 style="background-image: url('/assets/images/u-blocks/interier-styles/6.jpg');"
                            >
                            </div>
                        </div>
                        <div class="interior_styles__item-description">
                            <div class="interior_styles__item-name">
                                Офис
                            </div>
                            <div class="interior_styles__item-amount">
                                Более 3 500 товаров
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </main>



        <main class="py-4 interior_styles">
            <h2 class="title_h2">Стили</h2>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a class="interior_styles__item"
                       href="#"
                    >
                        <div class="interior_styles__item-image-box">
                            <div class="interior_styles__item-image"
                                 style="background-image: url('/assets/images/u-blocks/interier-styles/1.jpg');"
                            >
                            </div>
                        </div>
                        <div class="interior_styles__item-description">
                            <div class="interior_styles__item-name">
                                Прованс
                            </div>
                            <div class="interior_styles__item-amount">
                                Более 4 000 товаров
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a class="interior_styles__item"
                       href="#"
                    >
                        <div class="interior_styles__item-image-box">
                            <div class="interior_styles__item-image"
                                 style="background-image: url('/assets/images/u-blocks/interier-styles/2.jpg');"
                            >
                            </div>
                        </div>
                        <div class="interior_styles__item-description">
                            <div class="interior_styles__item-name">
                                Лофт
                            </div>
                            <div class="interior_styles__item-amount">
                                Более 25 000 товаров
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a class="interior_styles__item"
                       href="#"
                    >
                        <div class="interior_styles__item-image-box">
                            <div class="interior_styles__item-image"
                                 style="background-image: url('/assets/images/u-blocks/interier-styles/3.jpg');"
                            >
                            </div>
                        </div>
                        <div class="interior_styles__item-description">
                            <div class="interior_styles__item-name">
                                Скандинавский
                            </div>
                            <div class="interior_styles__item-amount">
                                Более 6 000 товаров
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a class="interior_styles__item"
                       href="#"
                    >
                        <div class="interior_styles__item-image-box">
                            <div class="interior_styles__item-image"
                                 style="background-image: url('/assets/images/u-blocks/interier-styles/4.jpg');"
                            >
                            </div>
                        </div>
                        <div class="interior_styles__item-description">
                            <div class="interior_styles__item-name">
                                Классический
                            </div>
                            <div class="interior_styles__item-amount">
                                Более 3 300 товаров
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a class="interior_styles__item"
                       href="#"
                    >
                        <div class="interior_styles__item-image-box">
                            <div class="interior_styles__item-image"
                                 style="background-image: url('/assets/images/u-blocks/interier-styles/5.jpg');"
                            >
                            </div>
                        </div>
                        <div class="interior_styles__item-description">
                            <div class="interior_styles__item-name">
                                Кантри
                            </div>
                            <div class="interior_styles__item-amount">
                                Более 8 400 товаров
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a class="interior_styles__item"
                       href="#"
                    >
                        <div class="interior_styles__item-image-box">
                            <div class="interior_styles__item-image"
                                 style="background-image: url('/assets/images/u-blocks/interier-styles/6.jpg');"
                            >
                            </div>
                        </div>
                        <div class="interior_styles__item-description">
                            <div class="interior_styles__item-name">
                                Модерн
                            </div>
                            <div class="interior_styles__item-amount">
                                Более 3 500 товаров
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </main>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Заказ товара</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">Для быстрого заказа товара оставьте оставьте свой контактный номер телефона. Консультант mossebo.market свяжется и поможет с оформлением заказа.</p>
                        <input type="text" class="form-control mb-2" placeholder="Ваше имя" aria-label="Username" aria-describedby="basic-addon1">
                        <input type="text" class="form-control" placeholder="Ваш телефон" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="button" class="btn btn-primary">Отправить</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
