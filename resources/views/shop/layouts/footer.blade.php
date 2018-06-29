<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="footer__left">
                    <div>
                        <a href="{{ siteUrl() }}">
                            <svg class="symbol-logo symbol-logo--footer">
                                <use xlink:href="/assets/images/icons.svg#symbol-logo"></use>
                            </svg>
                        </a>
                    </div>

                    <div class="social-links mt-32">
                        <div class="social-links__container">
                            <div class="social-links__item">
                                <a
                                    href="https://www.instagram.com/remont.design/"
                                    class="social-links__link"
                                    target="_blank"
                                    rel="nofollow noreferrer noopener"
                                >
                                    <svg class="social-links__icon symbol-icon">
                                        <use xlink:href="/assets/images/icons.svg#social-in"></use>
                                    </svg>
                                </a>
                            </div>

                            <div class="social-links__item">
                                <a
                                    href="https://vk.com/design_mossebo"
                                    class="social-links__link"
                                    target="_blank"
                                    rel="nofollow noreferrer noopener"
                                >
                                    <svg class="social-links__icon symbol-icon">
                                        <use xlink:href="/assets/images/icons.svg#social-vk"></use>
                                    </svg>
                                </a>
                            </div>

                            <div class="social-links__item">
                                <a
                                    href="https://www.facebook.com/mossebodesign/"
                                    class="social-links__link"
                                    target="_blank"
                                    rel="nofollow noreferrer noopener"
                                >
                                    <svg class="social-links__icon symbol-icon">
                                        <use xlink:href="/assets/images/icons.svg#social-fb"></use>
                                    </svg>
                                </a>
                            </div>

                            <div class="social-links__item">
                                <a
                                    href="https://ok.ru/mossebodesign"
                                    class="social-links__link"
                                    target="_blank"
                                    rel="nofollow noreferrer noopener"
                                >
                                    <svg class="social-links__icon symbol-icon">
                                        <use xlink:href="/assets/images/icons.svg#social-ok"></use>
                                    </svg>
                                </a>
                            </div>

                            <div class="social-links__item">
                                <a
                                    href="https://zen.yandex.ru/id/594cd65e8e557d52357758b2"
                                    class="social-links__link"
                                    target="_blank"
                                    rel="nofollow noreferrer noopener"
                                >
                                    <svg class="social-links__icon symbol-icon">
                                        <use xlink:href="/assets/images/icons.svg#social-zen"></use>
                                    </svg>
                                </a>
                            </div>

                            <div class="social-links__item">
                                <a
                                    href="https://ru.pinterest.com/mossebo0752/"
                                    class="social-links__link"
                                    target="_blank"
                                    rel="nofollow noreferrer noopener"
                                >
                                    <svg class="social-links__icon symbol-icon">
                                        <use xlink:href="/assets/images/icons.svg#social-pi"></use>
                                    </svg>
                                </a>
                            </div>

                            <div class="social-links__item">
                                <a
                                    href="https://www.youtube.com/channel/UCmoIMunKnQwi0ui_G9W0Wmw"
                                    class="social-links__link"
                                    target="_blank"
                                    rel="nofollow noreferrer noopener"
                                >
                                    <svg class="social-links__icon symbol-icon">
                                        <use xlink:href="/assets/images/icons.svg#social-you"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="footer-company-info mt-24">
                        {!! __('layouts.footer-company-info') !!}
                    </div>

                    <div class="mt-32">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-9 col-md-6">
                                <button class="button button-light button-long js-pop-up-call">
                                    {{ __('layouts.footer-recall') }}
                                </button>
                            </div>

                            <div class="col-9 col-md-6">
                                <button class="button button-light button-long js-pop-up-message">
                                    {{ __('layouts.footer-write') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="footer-pay-group mt-32">
                        <div class="footer-pay-group__container">
                            <div class="footer-pay-group__item">
                                <svg class="pay-visa">
                                    <use xlink:href="/assets/images/icons.svg#pay-visa"></use>
                                </svg>
                            </div>

                            <div class="footer-pay-group__item">
                                <svg class="pay-maestro">
                                    <use xlink:href="/assets/images/icons.svg#pay-maestro"></use>
                                </svg>
                            </div>

                            <div class="footer-pay-group__item">
                                <svg class="pay-mastercard">
                                    <use xlink:href="/assets/images/icons.svg#pay-mastercard"></use>
                                </svg>
                            </div>

                            <div class="footer-pay-group__item d-none">
                                <svg class="pay-paypal">
                                    <use xlink:href="/assets/images/icons.svg#pay-paypal"></use>
                                </svg>
                            </div>

                            <div class="footer-pay-group__item">
                                <svg class="pay-yandex">
                                    <use xlink:href="/assets/images/icons.svg#pay-yandex"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row footer-nav">
                    <div class="col-md-4">
                        <nav>
                            <div class="footer-nav__title">
                                Магазин
                            </div>

                            <ul class="footer-nav__links">
                                <li class="footer-nav__item">
                                    <a href="{{ route('catalog') }}" class="footer-nav__link link">Каталог</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="{{ route('styles') }}" class="footer-nav__link link">Стили</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="{{ route('rooms') }}" class="footer-nav__link link">Комнаты</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="#" class="footer-nav__link link">Комплекты</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="#" class="footer-nav__link link">Распродажа</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="#" class="footer-nav__link link">Новинки</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="#" class="footer-nav__link link">Топ-продаж</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="#" class="footer-nav__link link">Наш выбор</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <div class="col-md-4">
                        <nav>
                            <div class="footer-nav__title">
                                Покупателю
                            </div>

                            <ul class="footer-nav__links">
                                <li class="footer-nav__item">
                                    <a href="{{ route('help-article', ['slug' => 'delivery']) }}" class="footer-nav__link link">Доставка</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="{{ route('help-article', ['slug' => 'pay']) }}" class="footer-nav__link link">Оплата</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="{{ route('help-article', ['slug' => 'garant']) }}" class="footer-nav__link link">Гарантии</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="#" class="footer-nav__link link">Поддержка</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="#" class="footer-nav__link link">Акции</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="#" class="footer-nav__link link">Отзывы</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="#" class="footer-nav__link link">FAQ</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <div class="col-md-4">
                        <nav>
                            <div class="footer-nav__title">
                                Компания
                            </div>

                            <ul class="footer-nav__links">
                                <li class="footer-nav__item">
                                    <a href="#" class="footer-nav__link link">О нас</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="#" class="footer-nav__link link">Проекты</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="#" class="footer-nav__link link">Блог</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="#" class="footer-nav__link link">Вакансии</a>
                                </li>
                                <li class="footer-nav__item">
                                    <a href="#" class="footer-nav__link link">Контакты</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="footer-bottom">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="rcopy">
                    &copy; 2017-{{ date("Y") }} Mossebo.Market
                </div>
            </div>
            <div class="col-md-5 footer-bottom__links">
                <div class="row">
                    <div class="col-lg-6">
                        <a href="#" class="footer-link">Правила пользования</a>
                    </div>

                    <div class="col-lg-6">
                        <a href="{{ route('privacy') }}" class="footer-link">Политика конфиденциальности</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Callback -->
<div id="pop-up-call" class="pop-up mfp-hide animated zoomIn">
    <div class="block-ui">
        <form>
            <div class="pop-up__title title-h3">
                Обратный звонок
            </div>

            <div class="pop-up__desc">
                Заполните короткую форму и мы свяжемся с Вами в ближайшее время!
            </div>

            <div class="pop-up__input">
                <div class="form-group">
                    <label for="pop-up__call_name" class="form-label">
                        Имя
                    </label>

                    <input
                        id="pop-up__call_name"
                        type="text"
                        class="form-input"
                        name="name"
                        required
                    >
                </div>

                <div class="form-group mt-24">
                    <label for="pop-up__call_tel" class="form-label">
                        Телефон
                    </label>

                    <input
                        id="pop-up__call_tel"
                        type="tel"
                        class="form-input"
                        name="tel"
                        required
                    >
                </div>
            </div>

            <div class="mt-24">
                <button type="submit" class="button button-primary">
                    Отправить
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal msg-back -->
<div id="pop-up-message" class="pop-up mfp-hide animated zoomIn">
    <div class="block-ui">
        <form>
            <div class="pop-up__title title-h3">
                Напишите нам
            </div>

            <div class="pop-up__desc">
                Заполните короткую форму и мы свяжемся с Вами в ближайшее время!
            </div>

            <div class="pop-up__input">
                <div class="form-group">
                    <label for="pop-up__message_name" class="form-label">
                        Имя
                    </label>

                    <input
                        id="pop-up__message_name"
                        type="text"
                        class="form-input"
                        name="name"
                        required
                    >
                </div>

                <div class="form-group mt-24">
                    <label for="pop-up__message_tel" class="form-label">
                        Телефон
                    </label>

                    <input
                        id="pop-up__message_tel"
                        type="tel"
                        class="form-input"
                        name="tel"
                        required
                    >
                </div>

                <div class="form-group mt-24">
                    <label for="pop-up__message_message" class="form-label">
                        Ваше сообщение
                    </label>

                    <textarea
                        id="pop-up__message_message"
                        rows="6"
                        class="form-input"
                        name="message"
                        required
                    ></textarea>
                </div>
            </div>

            <div class="mt-24">
                <button type="submit" class="button button-primary">
                    Отправить
                </button>
            </div>
        </form>
    </div>
</div>
