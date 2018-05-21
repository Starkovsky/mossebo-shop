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
                <a href="#" class="cart"
                >
                    <div class="d-flex flex-nowrap align-items-center">
                        <div class="cart-icon">
                            <div class="badge">3</div>
                            <svg class="symbol-icon symbol-cart">
                                <use xlink:href="/assets/images/icons.svg#symbol-cart"></use>
                            </svg>
                        </div>
                        <div>
                            <div class="cart-name">
                                Корзина
                            </div>
                            <div class="cart-result">
                                <span class="items">3</span> шт. - <span class="prices">100 000 ₽</span>
                            </div>
                        </div>
                        <svg class="symbol-icon symbol-keyboard-down">
                            <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
                        </svg>
                    </div>
                </a>
            </div>

            <div class="header-float-item">
                <a href="#" class="profile"
                   data-toggle="dropdown"
                   aria-haspopup="true"
                   aria-expanded="false"
                >
                    <div class="d-flex flex-nowrap align-items-center">
                        <div class="profile-icon">
                            <svg class="symbol-icon symbol-person">
                                <use xlink:href="/assets/images/icons.svg#symbol-person"></use>
                            </svg>
                        </div>
                        <div>
                            <div class="profile-name">
                                Личный кабинет
                            </div>
                        </div>
                        <svg class="symbol-icon symbol-keyboard-down">
                            <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
                        </svg>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @guest
                        <a class="dropdown-item" href="{{ route('login') }}">{{ __('auth.login') }}</a>
                        <a class="dropdown-item" href="{{ route('register') }}">{{ __('auth.register') }}</a>
                    @else
                        <!-- <a class="dropdown-item">{{ __('auth.welcome') }}, {{ Auth::user()->name }}</a> -->
                        <a href="#" class="dropdown-item">Мои заказы</a>
                        <a href="#" class="dropdown-item">Профиль</a>
                        <a href="#" class="dropdown-item">Отзывы</a>
                        <a href="#" class="dropdown-item">Вопросы</a>
                        <a href="#" class="dropdown-item gray">Помощь</a>
                        <a class="dropdown-item logout"
                           href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        >
                            {{ __('auth.logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>

            <div class="header-float-item">
                <a href="#" class="search"
                >
                    <div class="d-flex flex-nowrap align-items-center">
                        <div class="search-icon">
                            <svg class="symbol-icon symbol-search">
                                <use xlink:href="/assets/images/icons.svg#symbol-search"></use>
                            </svg>
                        </div>
                        <div>
                            <div class="search-name">
                                Поиск
                            </div>
                        </div>
                    </div>
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
                <a href="#" class="location"
                >
                    <div class="d-flex flex-nowrap align-items-center">
                        <div class="location-icon">
                            <svg class="symbol-icon symbol-location">
                                <use xlink:href="/assets/images/icons.svg#symbol-location"></use>
                            </svg>
                        </div>
                        <div>
                            <div class="location-name">
                                Санкт-Петербург
                            </div>
                            <div class="location-phone">
                                8 (800) 000-00-00
                            </div>
                        </div>
                        <svg class="symbol-icon symbol-keyboard-down">
                            <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
</header>

<div class="header-mobile-fix"></div>
