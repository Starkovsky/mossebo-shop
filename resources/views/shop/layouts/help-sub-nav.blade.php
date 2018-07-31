@php
    $isArticle = Route::currentRouteName() === 'help-article';
    $currentSlug = $isArticle ? Route::current()->parameters['slug'] : '';
@endphp

<ul class="side-menu">
    <li class="side-menu__item">
        <a
            href="{{ route('help-article', ['slug' => 'delivery']) }}"
            class="side-menu__link{{ $isArticle && $currentSlug == 'delivery' ? ' active' : '' }}"
        >
            Условия доставки
        </a>
    </li>

    <li class="side-menu__item">
        <a
            href="{{ route('help-article', ['slug' => 'pay']) }}"
            class="side-menu__link{{ $isArticle && $currentSlug == 'pay' ? ' active' : '' }}"
        >
            Способы оплаты
        </a>
    </li>

    <li class="side-menu__item">
        <a
            href="{{ route('help-article', ['slug' => 'garant']) }}"
            class="side-menu__link{{ $isArticle && $currentSlug == 'garant' ? ' active' : '' }}"
        >
            Гарантия и возврат
        </a>
    </li>
</ul>
