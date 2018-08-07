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
                                    href="{{ settings('public-social-instagram') }}"
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
                                    href="{{ settings('public-social-vkontakte') }}"
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
                                    href="{{ settings('public-social-facebook') }}"
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
                                    href="{{ settings('public-social-odnoklassniki') }}"
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
                                    href="{{ settings('public-social-zen') }}"
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
                                    href="{{ settings('public-social-pinterest') }}"
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
                                    href="{{ settings('public-social-youtube') }}"
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
                                <a href="#popup-call" class="button button-light button-long js-form-popup">
                                    {{ __('layouts.footer-recall') }}
                                </a>
                            </div>

                            <div class="col-9 col-md-6">
                                <a href="#popup-feedback" class="button button-light button-long js-form-popup">
                                    {{ __('layouts.footer-write') }}
                                </a>
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
                        <a href="{{ route('use_policy') }}" class="footer-link">Правила пользования</a>
                    </div>

                    <div class="col-lg-6">
                        <a href="{{ route('privat_policy') }}" class="footer-link">Политика конфиденциальности</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-none">
    <!-- Modal Callback -->
    <div id="popup-call" class="popup animated zoomIn block-ui">
        <form class="js-form-sender" action="{{ siteUrl('forms/callback') }}">
            <div class="popup__top">
                <div class="popup__title title-h3">
                    Обратный звонок
                </div>

                <div class="popup__desc">
                    Заполните короткую форму и мы свяжемся с Вами в ближайшее время!
                </div>
            </div>

            <div class="popup__content">
                <div class="popup__form">
                    <div class="form-group js-form-group">
                        <label for="popup-callback-name" class="form-label">
                            Имя
                        </label>

                        <input
                            id="popup-callback-name"
                            type="text"
                            class="form-input"
                            name="name"
                            maxlength="255"
                            required
                        >
                    </div>

                    <div class="form-group mt-24 js-form-group">
                        <label for="popup-callback-phone" class="form-label">
                            Телефон
                        </label>

                        <input
                            id="popup-callback-phone"
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
                            Отправить
                        </span>

                        <svg class="button-loading__loader">
                            <use xlink:href="/assets/images/icons.svg#symbol-spinner"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal msg-back -->
    <div id="popup-feedback" class="popup animated zoomIn block-ui">
        <form class="js-form-sender" action="{{ siteUrl('forms/feedback') }}">
            <div class="popup__top">
                <div class="popup__title title-h3">
                    Напишите нам
                </div>

                <div class="popup__desc">
                    Заполните короткую форму и мы свяжемся с Вами в ближайшее время!
                </div>
            </div>

            <div class="popup__content">
                <div class="popup__form">
                    <div class="form-group js-form-group">
                        <label for="popup-feedback-name" class="form-label">
                            Имя
                        </label>

                        <input
                            id="popup-feedback-name"
                            type="text"
                            class="form-input"
                            name="name"
                            maxlength="255"
                            required
                        >
                    </div>

                    <div class="form-group mt-24 js-form-group">
                        <label for="popup-feedback-phone" class="form-label">
                            Телефон
                        </label>

                        <input
                            id="popup-feedback-phone"
                            type="tel"
                            class="form-input"
                            name="phone"
                            minlength="6"
                            maxlength="255"
                            required
                        >
                    </div>

                    <div class="form-group mt-24 js-form-group">
                        <label for="popup-feedback-message" class="form-label">
                            Ваше сообщение
                        </label>

                        <textarea
                            id="popup-feedback-message"
                            rows="6"
                            class="form-textarea"
                            name="message"
                            maxlength="2048"
                            required
                        ></textarea>
                    </div>
                </div>
            </div>

            <div class="popup__bottom">
                <div class="popup__button">
                    <button type="submit" class="button button-loading button-primary button-long">
                        <span class="button-loading__content">
                            Отправить
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


