<ul class="faq-sub-nav">
    <li class="faq-sub-nav__item">
        <a href="{{ route('delivery') }}"
           class="faq-sub-nav__link {{ Route::current()->getName() == 'delivery' ? 'active' : '' }}"
        >
            Условия доставки
        </a>
    </li>
    <li class="faq-sub-nav__item">
        <a href="{{ route('pay') }}"
           class="faq-sub-nav__link {{ Route::current()->getName() == 'pay' ? 'active' : '' }}"
        >
            Способы оплаты
        </a>
    </li>
    <li class="faq-sub-nav__item">
        <a href="{{ route('garant') }}"
           class="faq-sub-nav__link {{ Route::current()->getName() == 'garant' ? 'active' : '' }}"
        >
            Гарантия и возврат
        </a>
    </li>
</ul>
