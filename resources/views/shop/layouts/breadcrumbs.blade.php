@php
    if(\Request::route() != null) {
        $page_route_name = \Request::route()->getName();
    } else {
     $page_route_name = '';
    }
@endphp

@if($page_route_name != 'home')

<div class="container">
    <ul class="shop-breadcrumb">
        <li class="shop-breadcrumb-item">
            <a href="{{ route('home') }}">
                Главная
            </a>
            <svg class="symbol-icon symbol-person">
                <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
            </svg>
        </li>
        @if(isset($category))
            @foreach($category->ancestors as $ancestor)
                <li class="shop-breadcrumb-item">
                    <a href="{{ route('catalog', $ancestor->slug) }}">
                        {{ $ancestor->i18n->title }}
                    </a>
                    <svg class="symbol-icon symbol-person">
                        <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
                    </svg>
                </li>
            @endforeach
                <li class="shop-breadcrumb-item">
                    <a>
                        {{ $category->i18n->title }}
                    </a>
                </li>
        @endif

        @if($page_route_name == 'good')

            <li class="shop-breadcrumb-item">
                <a>
                    {{ $product->i18n->title }}
                </a>
            </li>

        @endif
    </ul>
</div>

@endif
