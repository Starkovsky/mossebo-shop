<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('/' . App::getLocale()) }}" class="logo footer-logo">
                    <img src="/assets/images/mossebo_market_logo.svg"
                         alt="{{ config('app.name', 'Laravel') }}"
                         class="logo__image">
                </a>
                <div class="footer-button-group">
                    <a href="#" class="button">Позвонить</a>
                    <a href="#" class="button button-light">Написать</a>
                </div>
                <div class="footer-pay-group">
                    <img src="/assets/images/icons/visa.svg" alt="Visa" class="visa">
                </div>
            </div>
            <div class="col-md-6">

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
