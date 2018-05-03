<header class="header">
    <div class="container">
        <div class="header-float">
            <div class="header-float-item">
                <a href="#" class="mobile-catalog">
                    <svg class="symbol-icon symbol-menu">
                        <use xlink:href="/assets/images/icons.svg#symbol-menu"></use>
                    </svg>
                </a>
            </div>

            <div class="header-float-item">
                <a href="#" class="mobile-cart"
                >
                    <div class="badge">3</div>
                    <svg class="symbol-icon symbol-cart">
                        <use xlink:href="/assets/images/icons.svg#symbol-cart"></use>
                    </svg>
                </a>
            </div>
            <div class="header-float-item">
                <a href="#" class="mobile-profile"
                >
                    <svg class="symbol-icon symbol-person">
                        <use xlink:href="/assets/images/icons.svg#symbol-person"></use>
                    </svg>
                </a>
            </div>
            <div class="header-float-item">
                <a href="#" class="mobile-search"
                >
                    <svg class="symbol-icon symbol-search">
                        <use xlink:href="/assets/images/icons.svg#symbol-search"></use>
                    </svg>
                </a>
            </div>

            <div class="header-float-item">
                <a href="{{ url('/' . App::getLocale()) }}" class="logo">
                    <svg class="symbol-icon symbol-logo-ru">
                        <use xlink:href="/assets/images/icons.svg#{{ __('layouts.mossebo-market-logo') }}"></use>
                    </svg>
                </a>
            </div>
            <div class="header-float-item">
                <div>
                    <a href="#" class="load-sities">Санкт-Петербург</a>
                    <div class="phone">8 (800) 000-00-00<small>с 10:00 до 22:00</small></div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="header-mobile-fix"></div>
