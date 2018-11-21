@extends('shop.layouts.html')

@section('content')
    <div class="container">
        <div class="auth auth--registration block-ui">
            <form method="POST" action="{{ route('register') }}" class="js-registration-form">
                @csrf

                <div class="auth__top container">
                    <h1 class="auth__title title-h1">
                        Создание аккаунта
                    </h1>

                    <div class="auth__title-label">
                        Аккаунт позволит вам добавлять товары в избранное, отслеживать заказы,  а также получать скидки и специальные предложения.
                    </div>

                    @if($socialUser)
                        <input type="hidden"
                               name="provider_user_id"
                               value="{{ $socialUser->getId() }}"
                        >
                        <input type="hidden"
                               name="provider"
                               value="{{ $provider }}"
                        >

                        <div class="social-user-info">
                            <div
                                style="background-image: url({{ $socialUser->getAvatar() }});"
                                class="social-user-info__avatar"
                            ></div>

                            <div class="social-user-info__name">
                                {{ $socialUser->getName() }}
                            </div>
                        </div>
                    @else
                        <div class="auth-socials auth-socials--short">
                            <div class="auth-socials__container">
                                <div class="auth-socials__item">
                                    <a href="{{ route('login-social', ['provider' => 'vkontakte']) }}"
                                       class="auth-social-btn auth-social-btn--circle auth-social-btn--vk"
                                    >
                                        <svg class="symbol-icon social-embed-vk">
                                            <use xlink:href="/assets/images/icons.svg#social-embed-vk"></use>
                                        </svg>
                                    </a>
                                </div>

                                <div class="auth-socials__item">
                                    <a href="{{ route('login-social', ['provider' => 'odnoklassniki']) }}"
                                       class="auth-social-btn auth-social-btn--circle auth-social-btn--ok"
                                    >
                                        <svg class="symbol-icon social-embed-ok">
                                            <use xlink:href="/assets/images/icons.svg#social-embed-ok"></use>
                                        </svg>
                                    </a>
                                </div>

                                <div class="auth-socials__item">
                                    <a href="{{ route('login-social', ['provider' => 'facebook']) }}"
                                       class="auth-social-btn auth-social-btn--circle auth-social-btn--fb"
                                    >
                                        <svg class="symbol-icon social-embed-fb">
                                            <use xlink:href="/assets/images/icons.svg#social-embed-fb"></use>
                                        </svg>
                                    </a>
                                </div>

                                <div class="auth-socials__item">
                                    <a href="{{ route('login-social', ['provider' => 'google']) }}"
                                       class="auth-social-btn auth-social-btn--circle auth-social-btn--google"
                                    >
                                        <svg class="symbol-icon social-embed-google">
                                            <use xlink:href="/assets/images/icons.svg#social-embed-google"></use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="auth__bottom container">
                    <div class="auth__mobile-or mb-24">
                        Или
                    </div>

                    <div class="auth-form auth-form--registration">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group js-form-group">
                                    <label for="registration-first-name" class="form-label">
                                        Имя
                                    </label>

                                    <input
                                        id="registration-first-name"
                                        type="text"
                                        class="form-input"
                                        name="first_name"
                                        required
                                        @if($socialUser)value="{{ $first_name }}"@endif
                                    >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group js-form-group">
                                    <label for="registration-last-name" class="form-label">
                                        Фамилия
                                    </label>

                                    <input
                                        id="registration-last-name"
                                        type="text"
                                        class="form-input"
                                        name="last_name"
                                        required
                                        @if($socialUser)value="{{ $last_name }}"@endif
                                    >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group js-form-group">
                                    <label for="registration-phone" class="form-label">
                                        Телефон
                                    </label>

                                    <input
                                        id="registration-phone"
                                        type="tel"
                                        class="form-input"
                                        name="phone"
                                        required
                                        @if($socialUser)value="{{ $phone }}"@endif
                                    >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group js-form-group">
                                    <label for="registration-email" class="form-label">
                                        E-Mail
                                    </label>

                                    <input
                                        id="registration-email"
                                        type="email"
                                        class="form-input"
                                        name="email"
                                        required
                                        @if($socialUser)value="{{ $email }}"@endif
                                    >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group js-form-group">
                                    <label for="registration-password" class="form-label">
                                        Пароль
                                    </label>

                                    <input
                                        id="registration-password"
                                        type="password"
                                        class="form-input"
                                        name="password"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group js-form-group">
                                    <label for="registration-password-confirm" class="form-label">
                                        Подтверждение пароля
                                    </label>

                                    <input
                                        id="registration-password-confirm"
                                        type="password"
                                        class="form-input"
                                        name="password_confirmation"
                                        required
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="mt-32">
                            <button type="submit" class="button button-primary button-loading login">
                                <span class="button-loading__content">
                                    Создать аккаунт
                                </span>

                                <svg class="button-loading__loader">
                                    <use xlink:href="/assets/images/icons.svg#symbol-spinner"></use>
                                </svg>
                            </button>
                        </div>

                        <div class="mt-32 auth__title-label">
                            Нажимая кнопку «Создать аккаунт», вы соглашаетесь с условиями

                            <a href="{{ route('use_policy') }}" class="link">
                                пользовательского соглашения
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
