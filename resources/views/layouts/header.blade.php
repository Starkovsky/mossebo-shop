<header class="header">
    <div class="container">
        <div class="header-float">
            <div class="header-float-item">
                <a href="#" class="mobile-catalog">
                    <i class="md-icon align-middle">dehaze</i>
                </a>
            </div>

            <div class="header-float-item">
                <a href="#" class="mobile-cart"
                >
                    <div class="badge">3</div>
                    <i class="md-icon">
                        shopping_cart
                    </i>
                </a>
            </div>
            <div class="header-float-item">
                <a href="#" class="mobile-profile"
                >
                    <i class="md-icon">person</i>
                </a>
            </div>
            <div class="header-float-item">
                <a href="#" class="mobile-search"
                >
                    <i class="md-icon">search</i>
                </a>
            </div>

            <div class="header-float-item">
                <a href="{{ url('/' . App::getLocale()) }}" class="logo">
                    <svg class="symbol-logo-ru">
                        <use xlink:href="/assets/images/icons.svg#{{ __('layouts.mossebo-market-logo') }}"></use>
                    </svg>
                </a>
            </div>
            <div class="header-float-item">
                <div>
                    <a href="#" class="load-sities">Санкт-Петербург <i class="md-icon">expand_more</i></a>
                    <div class="phone">8 (800) 000-00-00<small>с 10:00 до 22:00</small></div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="header-mobile-fix"></div>
