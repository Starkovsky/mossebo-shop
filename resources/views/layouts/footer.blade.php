<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('/' . App::getLocale()) }}" class="logo footer-logo">
                    <img src="/assets/images/mossebo_market_logo.svg"
                         alt="{{ config('app.name', 'Laravel') }}"
                         class="logo__image">
                </a>
                <div class="footer-logo-description">
                    {{ __('layouts.footer-logo-description') }}
                </div>
                <div class="footer-button-group">
                    <a href="#" class="button button-light">{{ __('layouts.footer-recall') }}</a>
                    <a href="#" class="button button-light">{{ __('layouts.footer-write') }}</a>
                </div>
                <div class="footer-pay-group">
                    <img src="/assets/images/icons/visa.svg" alt="Visa" class="footer-pay-icon">
                    <img src="/assets/images/icons/maestro.svg" alt="Maestro" class="footer-pay-icon">
                    <img src="/assets/images/icons/mastercard.svg" alt="Mastercard" class="footer-pay-icon">
                    <img src="/assets/images/icons/paypal.svg" alt="PayPal" class="footer-pay-icon">
                </div>
            </div>
            <div class="col-md-6">
                <div class="row justify-content-between">
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
            <div class="col-md-3">
                <div class="social-links">
                    <a href="#" class="social-links__item" target="_blank">
                        <img src="/assets/images/icons/vk.svg" alt="Vkontakte">
                    </a>
                    <a href="#" class="social-links__item" target="_blank">
                        <img src="/assets/images/icons/in.svg" alt="Instagram">
                    </a>
                    <a href="#" class="social-links__item" target="_blank">
                        <img src="/assets/images/icons/fb.svg" alt="Facebook">
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="rcopy">
                    &copy; 2017-@php echo date("Y") @endphp Mossebo.Market
                </div>
            </div>
            <div class="col-md-6 text-right">
                <a href="#" class="footer-link mr-5">Политика конфиденциальности</a>
                <a href="#" class="footer-link">Правила пользования</a>
            </div>
        </div>
    </div>
</div>
