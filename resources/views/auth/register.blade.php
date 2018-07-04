@extends('shop.layouts.html')

@section('content')
    <div class="container">
        <div class="auth auth--registration block-ui">
            <form method="POST" action="{{ route('register') }}">
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
                                    <a href="{{ url('login/vkontakte') }}"
                                       class="auth-social-btn auth-social-btn--circle auth-social-btn--vk cricle"
                                    >
                                        <svg class="symbol-icon social-embed-vk">
                                            <use xlink:href="/assets/images/icons.svg#social-embed-vk"></use>
                                        </svg>
                                    </a>
                                </div>

                                <div class="auth-socials__item">
                                    <a href="{{ url('login/odnoklassniki') }}"
                                       class="auth-social-btn auth-social-btn--circle auth-social-btn--ok cricle"
                                    >
                                        <svg class="symbol-icon social-embed-ok">
                                            <use xlink:href="/assets/images/icons.svg#social-embed-ok"></use>
                                        </svg>
                                    </a>
                                </div>

                                <div class="auth-socials__item">
                                    <a href="{{ url('login/facebook') }}"
                                       class="auth-social-btn auth-social-btn--circle auth-social-btn--facebook"
                                    >
                                        <svg class="symbol-icon social-embed-fb">
                                            <use xlink:href="/assets/images/icons.svg#social-embed-fb"></use>
                                        </svg>
                                    </a>
                                </div>

                                <div class="auth-socials__item">
                                    <a href="{{ url('login/google') }}"
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
                                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    <label for="registration-first-name" class="form-label">
                                        Имя
                                    </label>

                                    <input
                                        id="registration-first-name"
                                        type="text"
                                        class="form-input"
                                        name="first_name"
                                        value="{{ old('first_name') }}"
                                        required
                                    >

                                    @if ($errors->has('first_name'))
                                        <span class="form-error">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    <label for="registration-last-name" class="form-label">
                                        Фамилия
                                    </label>

                                    <input
                                        id="registration-last-name"
                                        type="text"
                                        class="form-input"
                                        name="last_name"
                                        value="{{ old('last_name') }}"
                                        required
                                    >

                                    @if ($errors->has('last_name'))
                                        <span class="form-error">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label for="registration-phone" class="form-label">
                                        Телефон
                                    </label>

                                    <input
                                        id="registration-phone"
                                        type="tel"
                                        class="form-input"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        required
                                    >

                                    @if ($errors->has('phone'))
                                        <span class="form-error">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="registration-email" class="form-label">
                                        E-Mail
                                    </label>

                                    <input
                                        id="registration-email"
                                        type="email"
                                        class="form-input"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required
                                    >

                                    @if ($errors->has('email'))
                                        <span class="form-error">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
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

                                    @if ($errors->has('password'))
                                        <span class="form-error">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
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

                                    @if ($errors->has('password_confirmation'))
                                        <span class="form-error">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-32">
                            <button type="submit" class="button button-primary">
                                Создать аккаунт
                            </button>
                        </div>

                        <div class="mt-32 auth__title-label">
                            Нажимая кнопку «Создать аккаунт», вы соглашаетесь с условиями <a href="#" class="link">пользовательского соглашения</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
