@extends('shop.layouts.html')

@section('scripts')
    <script src="https://apis.google.com/js/platform.js?onload=initSubscribeButtons" defer></script>
    <script type="text/javascript" src="https://vk.com/js/api/openapi.js?156"></script>
    <script type="text/javascript" >
        VK.Widgets.Group("vk-groups", {mode: 3, no_cover: 1}, 76599685)
    </script>
@endsection

@section('content')
    <div class="about-us-page">
        <div class="container">
            <h1 class="title-h1">
                О нас
            </h1>

            <div class="about-us-page__introduction mb-32">
                Интернет-магазин для покупки мебели, освещения  и аксессуаров от лучших производителей  и поставщиков из России и других стран, созданный студией дизайна интерьера Mossebo.
            </div>

            <div class="row work-life-slider js-studio-work-life">
                <div class="col-md-4">
                    <img class="br-image" src="/assets/images/about/ozs.jpg" srcset="/assets/images/about/ozs@2x.jpg 2x" alt="ОЗС">
                </div>

                <div class="col-md-4">
                    <img class="br-image" src="/assets/images/about/marketing.jpg" srcset="/assets/images/about/marketing2x.jpg 2x" alt="Маркетинг">
                </div>

                <div class="col-md-4">
                    <img class="br-image" src="/assets/images/about/design.jpg" srcset="/assets/images/about/design@2x.jpg 2x" alt="Дизайн">
                </div>
            </div>

            <div class="about-us-page__info mt-80">
                <div class="about-us-info">
                    <h2 class="title-h2 text-center">
                        Международная сеть студий дизайна интерьера Mossebo
                    </h2>

                    <div class="about-us-info block-ui mt-32">
                        <div class="about-us-info__top row-container">
                            <div class="row">
                                <div class="about-us-info__left col-md-6">
                                    <div class="about-us-info__logo">
                                        <img src="/assets/images/studio/logo.png" srcset="/assets/images/studio/logo@2x.png 2x" alt="Моссэбо: дизайн интерьера и ремонт">
                                    </div>
                                </div>

                                <div class="about-us-info__right col-md-6">
                                    <div class="about-us-info__text article">
                                        <p>
                                            546 семей сделали ремонт в своих квартирах и коттеджах вместе с Mossebo в 2017 году.
                                            Наши филиалы расположены в Москве, Минске, Санкт-Петербурге, Волгограде, Бишкеке, и других городах России и СНГ.
                                        </p>

                                        <p>
                                            Мы создаем дизайн интерьера для всех объектов,  от квартиры студии до загородного коттеджа или офиса.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="about-us-info__bottom">
                            <img src="/assets/images/studio/map.jpg" srcset="/assets/images/studio/map@2x.jpg 2x" alt="Карта студий Моссэбо">
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-32">
                <div class="row work-life-slider js-studio-work-life">
                    <div class="col-lg-6">
                        <img class="br-image" src="/assets/images/about/just-doing-their-job.jpg" srcset="/assets/images/about/just-doing-their-job@2x.jpg 2x" alt="ОЗС">
                    </div>

                    <div class="col-lg-6">
                        <img class="br-image" src="/assets/images/about/just-doing-their-job-2.jpg" srcset="/assets/images/about/just-doing-their-job-2@2x.jpg 2x" alt="Маркетинг">
                    </div>
                </div>
            </div>
        </div>

        <div class="about-us-page__space">
            <div class="about-space-block about-space-block--know">
                <div class="about-space-block__container container">
                    <div class="about-space-block__content block-ui">
                        Знаем, как превращать  квадратные метры  в уютные квартиры
                    </div>
                </div>

                <img class="about-space-block__image" src="/assets/images/about/project.png" alt="Дизайн-проект">
            </div>

            <div class="container">
                <div class="watch-all-btn-wrap">
                    <a href="https://mossebo.studio/portfolio" class="watch-all-btn" target="_blank" rel="nofollow noreferrer noopener">
                    <span class="watch-all-btn__label">
                        Смотреть портфолио
                    </span>

                        <span class="watch-all-btn__icon-box">
                        <svg class="watch-all-btn__icon">
                            <use xlink:href="/assets/images/icons.svg#symbol-arrow-forward"></use>
                        </svg>
                    </span>
                    </a>
                </div>

                <h2 class="about-us-page__space-title title-h2 text-center">
                    В формате интернет-магазина
                </h2>
            </div>

            <div class="about-space-block about-space-block--we">
                <div class="about-space-block__container container">
                    <div class="about-space-block__content block-ui">
                        <div class="about-space-block__label">Мы</div>
                        Находим интересные товары  для вашего интерьера и делаем  выгодное предложение лучшим  производителям
                    </div>

                    <img class="about-space-block__image" src="/assets/images/about/box.png" alt="Посылка с товарами для вашего интерьера">
                </div>
            </div>

            <div class="about-space-block about-space-block--you">
                <div class="about-space-block__container container">
                    <img class="about-space-block__image" src="/assets/images/about/chair.png" alt="Посылка с товарами для вашего интерьера">

                    <div class="about-space-block__content block-ui">
                        <div class="about-space-block__label">Вы</div>
                        Легко и просто выбираете  эксклюзивные вещи в нужном  стиле по специальной цене
                    </div>
                </div>
            </div>

            <div class="about-space-block about-space-block--together">
                <div class="about-space-block__container container">
                    <div class="about-space-block__content block-ui">
                        <div class="about-space-block__label">Вместе</div>
                        Создаем уникальный дизайн  интерьера на любой стадии
                    </div>

                    <img class="about-space-block__image" src="/assets/images/about/chair.png" alt="Посылка с товарами для вашего интерьера">
                </div>
            </div>

            <div class="studio-production mt-80">
                <div class="container">
                    <h2 class="title-h2 text-center">
                        Mossebo Production
                    </h2>

                    <div class="studio-production__introduction">
                        Мы развиваем несколько медиа проектов, на которых продвигаем собственный бизнес на взрослую и платежеспособную аудиторию.
                    </div>

                    <div class="studio-production-row mt-60">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="studio-production-row__info">
                                    <div class="studio-production-row__channel">
                                        <div class="g-ytsubscribe" data-channelid="UCmoIMunKnQwi0ui_G9W0Wmw" data-layout="full" data-count="default"></div>
                                    </div>

                                    <div class="studio-production-row__text">
                                        <p>
                                            Хайповый бизнес – канал бизнес-интервью с известными и интересными людьми. Бизнесмены, top-менеджеры международных и российских компаний, звезды спорта и шоу-бизнеса – все они есть в выпусках на канале.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="studio-production-row__video">
                                    <div class="video-frame">
                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/VIBVyQ8P02M?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="studio-production-row studio-production-row--reverse mt-60">
                        <div class="row">

                            <div class="col-md-5">
                                <div class="studio-production-row__info">
                                    <div class="studio-production-row__channel">
                                        <div class="g-ytsubscribe" data-channelid="UCX4d_WGl2y04iATm6DtXAWg" data-layout="full" data-count="default"></div>
                                    </div>

                                    <div class="studio-production-row__text">
                                        <p>
                                            Вы собираетесь открывать бизнес и еще не знаете какой? Тогда добро пожаловать на канал TOP TOP. Мы уже сделали крутые подборки идей для бизнеса. Вам остается только внедрить их и зарабатывать деньги. Удачи!
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="studio-production-row__video">
                                    <div class="video-frame">
                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/vSqZ8PGOMOg?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="studio-production-row mt-60">
                        <div class="row">

                            <div class="col-md-5">
                                <div class="studio-production-row__info">
                                    <div class="studio-production-row__channel">
                                        <div class="g-ytsubscribe" data-channelid="UCmYjYyeZDuFb9hOgEUNYJuQ" data-layout="full" data-count="default"></div>
                                    </div>

                                    <div class="studio-production-row__text">
                                        <p>
                                            Канал о дизайне интерьера с элементами fashion, beauty и lifestyle.
                                        </p>

                                        <p>
                                            Ведущая канала и первый в России IKEA-art блогер - Liza Loft.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="studio-production-row__video">
                                    <div class="video-frame">
                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/B5dZkY625oc?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="subscribe-to-us mt-80">
                <div class="container">
                    <h2 class="title-h2 text-center">
                        Смотри, вдохновляйся, покупай
                    </h2>

                    <div class="subscribe-to-us__text mb-60 text-center">
                        А также получай рассылки с подборками лучших товаров и интерьерных решений, акциями и персональными скидками.
                    </div>

                    <div class="subscribe-to-us__form">
                        <div class="subscribe-form-row">
                            <div class="subscribe-form-row__email">
                                <label class="email-input">
                                    <input class="email-input__input" type="email" name="email" placeholder="Email...">

                                    <svg class="email-input__icon">
                                        <use xlink:href="/assets/images/icons.svg#symbol-letter"></use>
                                    </svg>
                                </label>
                            </div>

                            <div class="subscribe-form-row__submit">
                                <button type="submit" class="button button-primary button-long">
                                    Подписаться
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


