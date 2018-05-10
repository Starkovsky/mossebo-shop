<nav class="header-navigation d-none d-lg-block d-xl-block">
    <div class="container">
        <ul class="header-navigation-list">
            <li class="header-navigation-list__item header-navigation-catalog">
                <a href="/ru/catalog" class="">
                    <svg class="symbol-icon symbol-menu">
                        <use xlink:href="/assets/images/icons.svg#symbol-menu"></use>
                    </svg>
                    Каталог товаров</a>
            </li>
            {{--<li class="header-navigation-list__item">--}}
                {{--<a href="#" class="">Стили</a>--}}
            {{--</li>--}}
            <li class="header-navigation-list__item">
                <a href="#" class="">Комплекты</a>
            </li>
            {{--<li class="header-navigation-list__item">--}}
                {{--<a href="#" class="">Новинки</a>--}}
            {{--</li>--}}
            {{--<li class="header-navigation-list__item header-navigation-list-discount">--}}
                {{--<a href="#" class="">Скидки</a>--}}
            {{--</li>--}}
            <li class="header-navigation-list__item">
                <a href="/ru/delivery" class="">Доставка</a>
            </li>
            <li class="header-navigation-list__item">
                <a href="/ru/pay" class="">Оплата</a>
            </li>
            <li class="header-navigation-list__item">
                <a href="/ru/garant" class="">Гарантия и возврат</a>
            </li>
        </ul>
    </div>
</nav>
@php
    $categorys = App\Models\Shop\Category::with('i18n')->get()->toTree();
@endphp
<div class="catalog-nav">
    <div class="container">
        <div class="catalog-nav-box">
            <ul>
                @foreach($categorys as $category)
                    <li>
                        <a href="/{{ app()->getLocale() }}/catalog/{{ $category->slug }}">
                            {{ $category->i18n->title }}
                        </a>
                        <ul>
                            @foreach($category->children as $children)
                                <li>
                                    <a href="/{{ app()->getLocale() }}/catalog/{{ $children->slug }}">
                                        {{ $children->i18n->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
