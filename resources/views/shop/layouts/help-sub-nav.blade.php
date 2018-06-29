@php
    $isArticle = Route::currentRouteName() === 'help-article';
    $currentSlug = $isArticle ? Route::current()->parameters['slug'] : '';
@endphp

<ul class="help-sub-nav">
    <li class="help-sub-nav__item">
        <a href="{{ route('help-article', ['slug' => 'delivery']) }}"
           class="help-sub-nav__link{{ $isArticle && $currentSlug == 'delivery' ? ' active' : '' }}"
        >
            Условия доставки
        </a>
    </li>
    <li class="help-sub-nav__item">
        <a href="{{ route('help-article', ['slug' => 'pay']) }}"
           class="help-sub-nav__link{{ $isArticle && $currentSlug == 'pay' ? ' active' : '' }}"
        >
            Способы оплаты
        </a>
    </li>
    <li class="help-sub-nav__item">
        <a href="{{ route('help-article', ['slug' => 'garant']) }}"
           class="help-sub-nav__link{{ $isArticle && $currentSlug == 'garant' ? ' active' : '' }}"
        >
            Гарантия и возврат
        </a>
    </li>
</ul>
