@php
    $categories = Categories::where('products_count', '>', 0)->sortBy('position')->toTree();
@endphp

<div class="main-nav-wrap">
    <div class="container">
        <nav class="main-menu js-main-menu">

            <ul class="main-menu__container">
                <li class="main-menu__item">
                    <span class="main-menu__trigger catalog-mobile-link js-mobile-nav-btn" data-id="0">
                        Каталог товаров
                    </span>

                    <span class="main-menu__trigger catalog-desktop-link js-desktop-menu-btn">
                        <div class="catalog-desktop-link__icon">
                            <span class="catalog-desktop-link__line"></span>
                            <span class="catalog-desktop-link__line"></span>
                            <span class="catalog-desktop-link__line"></span>
                        </div>

                        <span class="catalog-desktop-link__label">
                            Каталог товаров
                        </span>
                    </span>
                </li>

                <li class="main-menu__item">
                    <a href="{{ siteUrl('styles') }}" class="main-menu__link">
                        Стили
                    </a>
                </li>

                <li class="main-menu__item">
                    <a href="{{ siteUrl('rooms') }}" class="main-menu__link">
                        Комнаты
                    </a>
                </li>

                <li class="main-menu__item">
                    <a href="{{ route('help-article', ['slug' => 'delivery']) }}" class="main-menu__link">
                        Доставка
                    </a>
                </li>

                <li class="main-menu__item">
                    <a href="{{ route('help-article', ['slug' => 'pay']) }}" class="main-menu__link">
                        Оплата
                    </a>
                </li>

                <li class="main-menu__item">
                    <a href="{{ route('help-article', ['slug' => 'garant']) }}" class="main-menu__link">
                        Гарантия и возврат
                    </a>
                </li>
            </ul>
        </nav>

        <nav class="catalog-nav js-catalog-nav">
            <div class="catalog-nav__inner block-ui js-catalog-nav--menu">
                <div class="catalog-nav__main">
                    <ul class="catalog-nav__sub js-catalog-nav--sub" data-id="0">
                        @foreach ($categories as $category)
                            <li class="catalog-nav__item">
                                @if (is_null($category->children))
                                    <a href="{{ siteUrl('catalog/' . $category->slug) }}" class="catalog-nav__link js-catalog-nav--link">
                                        {{ $category->title }}
                                    </a>
                                @else
                                    <span class="catalog-nav__trigger js-catalog-nav--link" data-id="{{ $category->id }}">
                                        {{ $category->title }}
                                    </span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="catalog-nav__subs js-catalog-nav--subs">
                    @foreach ($categories as $category)
                        @if (! is_null($category->children))
                            <ul class="catalog-nav__sub js-catalog-nav--sub" data-id="{{ $category->id }}">
                                @foreach($category->children as $children)
                                    <li class="catalog-nav__item">
                                        <a href="{{ siteUrl('catalog/' . $children->slug) }}" class="catalog-nav__link">
                                            {{ $children->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    @endforeach
                </div>
            </div>
        </nav>
    </div>
</div>
