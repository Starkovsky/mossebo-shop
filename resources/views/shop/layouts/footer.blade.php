<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('/' . App::getLocale()) }}" class="logo footer-logo">
                    <svg class="symbol-icon symbol-logo">
                        <use xlink:href="/assets/images/icons.svg#symbol-logo"></use>
                    </svg>
                </a>
                <div class="footer-logo-description">
                    {{ __('layouts.footer-logo-description') }}
                </div>
                <div class="footer-button-group">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#" class="button button-light btn-block">{{ __('layouts.footer-recall') }}</a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="button button-light btn-block">{{ __('layouts.footer-write') }}</a>
                        </div>
                    </div>
                </div>
                <div class="footer-pay-group">
                    <svg class="symbol-icon pay-visa">
                        <use xlink:href="/assets/images/icons.svg#pay-visa"></use>
                    </svg>
                    <svg class="symbol-icon pay-maestro">
                        <use xlink:href="/assets/images/icons.svg#pay-maestro"></use>
                    </svg>
                    <svg class="symbol-icon pay-mastercard">
                        <use xlink:href="/assets/images/icons.svg#pay-mastercard"></use>
                    </svg>
                    <svg class="symbol-icon pay-paypal">
                        <use xlink:href="/assets/images/icons.svg#pay-paypal"></use>
                    </svg>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row footer-nav">
                    <div class="col-md-4">
                        <nav>
                            <div class="footer-nav-title">Магазин</div>
                            <ul class="footer-nav-links">
                                <li class="footer-nav-links__item">
                                    <a href="#">Каталог</a>
                                </li>
                                <li class="footer-nav-links__item">
                                    <a href="#">Стили</a>
                                </li>
                                <li class="footer-nav-links__item">
                                    <a href="#">Комплекты</a>
                                </li>
                                <li class="footer-nav-links__item">
                                    <a href="#">Распродажа</a>
                                </li>
                                <li class="footer-nav-links__item">
                                    <a href="#">Новинки</a>
                                </li>
                                <li class="footer-nav-links__item">
                                    <a href="#">Топ-продаж</a>
                                </li>
                                <li class="footer-nav-links__item">
                                    <a href="#">Наш выбор</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-4">
                        <nav>
                            <div class="footer-nav-title">Покупателю</div>
                            <ul class="footer-nav-links">
                                <li class="footer-nav-links__item">
                                    <a href="#">Доставка</a>
                                </li>
                                <li class="footer-nav-links__item">
                                    <a href="#">Оплата</a>
                                </li>
                                <li class="footer-nav-links__item">
                                    <a href="#">Возврат</a>
                                </li>
                                <li class="footer-nav-links__item">
                                    <a href="#">Поддержка</a>
                                </li>
                                <li class="footer-nav-links__item">
                                    <a href="#">Акции</a>
                                </li>
                                <li class="footer-nav-links__item">
                                    <a href="#">Отзывы</a>
                                </li>
                                <li class="footer-nav-links__item">
                                    <a href="#">FAQ</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-4">
                        <nav>
                            <div class="footer-nav-title">Компания</div>
                            <ul class="footer-nav-links">
                                <li class="footer-nav-links__item">
                                    <a href="#">О нас</a>
                                </li>
                                <li class="footer-nav-links__item">
                                    <a href="#">Проекты</a>
                                </li>
                                <li class="footer-nav-links__item">
                                    <a href="#">Блог</a>
                                </li>
                                <li class="footer-nav-links__item">
                                    <a href="#">Вакансии</a>
                                </li>
                                <li class="footer-nav-links__item">
                                    <a href="#">Контакты</a>
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
            <div class="col-md-4">
                <div class="social-links">
                    <a href="https://www.instagram.com/remont.design/" class="social-links__item" target="_blank">
                        <svg class="symbol-icon social-in">
                            <use xlink:href="/assets/images/icons.svg#social-in"></use>
                        </svg>
                    </a>
                    <a href="https://vk.com/design_mossebo" class="social-links__item" target="_blank">
                        <svg class="symbol-icon social-vk">
                            <use xlink:href="/assets/images/icons.svg#social-vk"></use>
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/mossebodesign/" class="social-links__item" target="_blank">
                        <svg class="symbol-icon social-fb">
                            <use xlink:href="/assets/images/icons.svg#social-fb"></use>
                        </svg>
                    </a>
                    <a href="https://ok.ru/mossebodesign" class="social-links__item" target="_blank">
                        <svg class="symbol-icon social-ok">
                            <use xlink:href="/assets/images/icons.svg#social-ok"></use>
                        </svg>
                    </a>
                    <a href="https://zen.yandex.ru/id/594cd65e8e557d52357758b2" class="social-links__item" target="_blank">
                        <svg class="symbol-icon social-zen">
                            <use xlink:href="/assets/images/icons.svg#social-zen"></use>
                        </svg>
                    </a>
                    <a href="https://ru.pinterest.com/mossebo0752/" class="social-links__item" target="_blank">
                        <svg class="symbol-icon social-pi">
                            <use xlink:href="/assets/images/icons.svg#social-pi"></use>
                        </svg>
                    </a>
                    <a href="https://www.youtube.com/channel/UCmoIMunKnQwi0ui_G9W0Wmw"
                       class="social-links__item d-none d-sm-inline-block d-md-inline-block d-lg-inline-block d-xl-inline-block" target="_blank">
                        <svg class="symbol-icon social-you">
                            <use xlink:href="/assets/images/icons.svg#social-you"></use>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="rcopy">
                    &copy; 2017-@php echo date("Y") @endphp Mossebo.Market
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
