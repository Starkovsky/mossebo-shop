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
                    <img src="/assets/images/icons/visa.svg" alt="Visa" class="footer-pay-icon">
                    <img src="/assets/images/icons/maestro.svg" alt="Maestro" class="footer-pay-icon">
                    <img src="/assets/images/icons/mastercard.svg" alt="Mastercard" class="footer-pay-icon">
                    <img src="/assets/images/icons/paypal.svg" alt="PayPal" class="footer-pay-icon">
                </div>
            </div>
            <div class="col-md-6">
                <div class="row justify-content-between footer-nav">
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
                        <svg width="32" height="32" xmlns="http://www.w3.org/2000/svg">
                            <g fill="none" fill-rule="evenodd">
                                <circle class="svg_icon" fill-rule="nonzero" cx="15.8861593" cy="15.8861593" r="15.8861593"/>
                                <path d="M15.2860885 22.8536637h1.2468673s.3766371-.0413451.5689203-.2486372c.1769912-.1903008.1713274-.5476814.1713274-.5476814s-.0243539-1.6730619.7521416-1.9194336c.7654514-.2426903 1.7483894 1.6169912 2.7902301 2.3320354.787823.5411681 1.3864779.4225133 1.3864779.4225133l2.7856991-.0387965s1.4572743-.0897699.7663009-1.2355398c-.0566372-.0937345-.4024071-.8475752-2.0712212-2.3966018-1.7466903-1.6212389-1.5127788-1.3590088.591292-4.1633982 1.2814159-1.7078938 1.7936991-2.7505841 1.6336991-3.1971681-.1526372-.4253452-1.0950796-.3129204-1.0950796-.3129204l-3.1365664.0195398s-.2324956-.0317168-.4049558.0713629c-.1684955.1010973-.2769557.3367079-.2769557.3367079s-.4964248 1.3216283-1.1585133 2.4455929c-1.3966726 2.3716815-1.955115 2.4968496-2.1833628 2.349593-.5309735-.3432213-.3984425-1.3788319-.3984425-2.1145487 0-2.2983363.3486018-3.2566372-.6787965-3.504708-.3409557-.0824071-.5918584-.1367787-1.4637876-.1455575-1.1191504-.0116106-2.066407.0033982-2.602761.2661947-.3568142.1747257-.6320708.5641062-.4644248.5864779.207292.0277522.6768142.126584.9257345.4655575.3214159.4372389.3100885 1.4193274.3100885 1.4193274s.1846372 2.7055575-.431292 3.0416991c-.4227965.2305133-1.0027611-.2401416-2.2479292-2.3917876-.63801774-1.1021593-1.11971685-2.3204248-1.11971685-2.3204248s-.09288496-.2276814-.25854868-.3494513c-.20106194-.1475398-.4819823-.1945487-.4819823-.1945487L5.76 11.5486018s-.44743363.0124601-.61168142.2070088c-.14612389.1730266-.01161062.5309735-.01161062.5309735s2.33345133 5.4592566 4.97557524 8.2104071c2.4226549 2.5223362 5.1738053 2.3566725 5.1738053 2.3566725z" fill="#FFF"/>
                            </g>
                        </svg>
                    </a>
                    <a href="#" class="social-links__item" target="_blank">
                        <svg width="33" height="32" xmlns="http://www.w3.org/2000/svg">
                            <g class="svg_icon" fill-rule="nonzero">
                                <path d="M16.554667 19.06944c1.75296 0 3.18208-1.42656 3.18208-3.1808 0-.69248-.22656-1.33184-.6016-1.85408-.57792-.80128-1.51744-1.32672-2.57856-1.32672-1.06176 0-2.00064.5248-2.57984 1.32608-.37632.52224-.60096 1.1616-.6016 1.85408-.00192 1.75424 1.42592 3.18144 3.17952 3.18144zM23.500587 11.99744V8.9344l-.39872.00128-2.66496.00832.01024 3.06368z"/>
                                <path d="M16.555307 0C7.794347 0 .666667 7.12768.666667 15.88864c0 8.76032 7.12768 15.88864 15.88864 15.88864 8.76032 0 15.88864-7.12832 15.88864-15.88864C32.443947 7.12768 25.316907 0 16.555307 0zm9.03616 14.03456v7.3984c0 1.92704-1.56672 3.49312-3.49248 3.49312h-11.08736c-1.9264 0-3.49248-1.56608-3.49248-3.49312V10.3456c0-1.9264 1.56608-3.49248 3.49248-3.49248h11.08672c1.9264 0 3.49312 1.56608 3.49312 3.49248v3.68896z"/>
                                <path d="M21.498027 15.88864c0 2.72448-2.21696 4.94272-4.94272 4.94272-2.72576 0-4.94208-2.21824-4.94208-4.94272 0-.65536.13056-1.28192.36352-1.85408h-2.6976v7.3984c0 .95616.77632 1.73056 1.73184 1.73056h11.08672c.95424 0 1.73184-.7744 1.73184-1.73056v-7.3984h-2.69888c.23488.57216.36736 1.19872.36736 1.85408z"/>
                            </g>
                        </svg>
                    </a>
                    <a href="#" class="social-links__item" target="_blank">
                        <svg width="33" height="32" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.221973 0C7.461013 0 .333333 7.12768.333333 15.88864c0 8.76032 7.12768 15.88864 15.88864 15.88864 8.76032 0 15.88864-7.12832 15.88864-15.88864C32.110613 7.12768 24.983573 0 16.221973 0zm3.95136 16.448h-2.58496v9.21344h-3.8304V16.448h-1.8208v-3.25632h1.8208v-2.10624c0-1.50848.7168-3.8656 3.8656-3.8656l2.8384.01088v3.16096h-2.06016c-.33536 0-.81216.16768-.81216.88704v1.9136h2.9184l-.33472 3.25568z" class="svg_icon" fill-rule="nonzero"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="rcopy">
                    &copy; 2017-@php echo date("Y") @endphp Mossebo.Market
                </div>
            </div>
            <div class="col-md-6 footer-bottom__links">
                <div class="row">
                    <div class="col-md-6">
                        <a href="#" class="footer-link">Правила пользования</a>
                    </div>
                    <div class="col-md-6">
                        <a href="#" class="footer-link">Политика конфиденциальности</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
