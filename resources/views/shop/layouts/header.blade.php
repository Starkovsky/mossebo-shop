@php
    $banner = app()->make(App\Http\Controllers\BannerController::class)->getHeaderBanner();
@endphp

@if ($banner)
    <div class="header-banner-wrap js-header-banner">
        <header-banner
            link="{{ siteUrl($banner->link) }}"
            image="{{ $banner->image }}"
            mobile-image="{{ $banner->mobile_image }}"
        ></header-banner>
    </div>
@endif


<header class="header js-fixed-menu">
    <div class="header__fixer"></div>
    <div class="header__fixed js-fixed-menu-container">
        <div class="container">
            <div class="header-float js-fixed-menu-inner">
                <div class="header-float__item header-float__item--menu">
                    <span class="mobile-catalog-btn js-mobile-menu-btn">
                        <svg class="symbol-menu">
                            <use xlink:href="/assets/images/icons.svg#symbol-menu"></use>
                        </svg>
                    </span>
                </div>

                <div class="header-float__item header-float__item--logo">
                    <a href="{{ siteUrl() }}">
                        <svg class="symbol-logo symbol-logo--header">
                            <use xlink:href="/assets/images/icons.svg#symbol-logo-{{ App::getLocale() }}"></use>
                        </svg>
                    </a>
                </div>

                <div class="header-float__item header-float__item--city">
                    <cities-select></cities-select>
                </div>

                <div class="header-float__item header-float__item--search d-none">
                    <a href="#" class="search"
                    >
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
                    </a>
                </div>

                <div class="header-float__item header-float__item--auth">
                    <div class="ht-popup-wrap">
                        <a href="javascript:void(0);" class="profile js-ht">
                            <div class="profile-icon">
                                <svg class="symbol-icon symbol-person">
                                    <use xlink:href="/assets/images/icons.svg#symbol-person"></use>
                                </svg>
                            </div>

                            @guest
                                <div class="profile-name">
                                    Личный кабинет
                                </div>
                            @else
                                <div class="profile-name">
                                    {{ Auth::user()->first_name }}
                                </div>
                            @endguest

                            <svg class="symbol-icon symbol-keyboard-down">
                                <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
                            </svg>
                        </a>

                        <div class="ht-container ht-container--popup ht-container--right">
                            <div class="ht-inner block-ui">
                                @guest
                                    <a class="dropdown-item" href="{{ route('login') }}">{{ __('auth.login') }}</a>
                                    <a class="dropdown-item" href="{{ route('register') }}">{{ __('auth.register') }}</a>
                                @else
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
                    </div>
                </div>

                <div class="header-float__item header-float__item--cart">
                    <cart-btn></cart-btn>
                </div>
            </div>
        </div>
    </div>
</header>

@include('shop.layouts.nav')
