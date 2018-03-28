<header class="header">
    <div class="container">
        <div class="mr-auto">
            <a href="{{ url('/' . App::getLocale()) }}" class="logo">
                <img src="{{ asset('/assets/images/mossebo_market_logo.svg') }}"
                     alt="{{ config('app.name', 'Laravel') }}"
                     class="logo__image">
                <div class="logo__description">
                    {{ __('layouts.logo_description') }}
                </div>
            </a>
        </div>
    </div>
</header>
