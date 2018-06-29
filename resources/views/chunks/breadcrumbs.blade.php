@if (count($breadcrumbs))
    <div class="main-layout__breadcrumbs">
        <div class="container">
            <nav class="shop-breadcrumbs">
                <div class="shop-breadcrumbs__container">
                    @foreach ($breadcrumbs as $breadcrumb)
                        @if ($breadcrumb->url && !$loop->last)
                            <div class="shop-breadcrumbs__item">
                                <a href="{{ $breadcrumb->url }}" class="shop-breadcrumbs__link link">
                                    {{ $breadcrumb->title }}
                                </a>
                            </div>

                            <div class="shop-breadcrumbs__item">
                                <svg class="shop-breadcrumbs__separator">
                                    <use xlink:href="/assets/images/icons.svg#symbol-chevron-right"></use>
                                </svg>
                            </div>
                        @else
                            <div class="shop-breadcrumbs__item">
                                <span class="shop-breadcrumbs__active">
                                    {{ $breadcrumb->title }}
                                </span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </nav>
        </div>
    </div>
@endif
