@extends('shop.layouts.html')

@section('content')
    <div class="container">
        <div class="auth auth--login block-ui">

            <div class="auth__top">
                <h1 class="auth__title title-h1">
                    Здравствуйте, войдите
                </h1>

                <div class="row row--no-padding">
                    <div class="col-md-6 auth__left">
                        <div class="container">
                            <div class="auth-socials">
                                <div class="auth-socials__container">
                                    <div class="auth-socials__item">
                                        <a href="{{ url('login/vkontakte') }}"
                                           class="auth-social-btn auth-social-btn--vk"
                                        >
                                            <div class="auth-social-btn__label">
                                                <span class="d-none d-lg-inline d-xl-inline">Войти через&nbsp;</span>
                                                Вконтакте
                                            </div>

                                            <div class="auth-social-btn__icon">
                                                <svg class="symbol-icon social-embed-vk">
                                                    <use xlink:href="/assets/images/icons.svg#social-embed-vk"></use>
                                                </svg>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="auth-socials__item">
                                        <a href="{{ url('login/facebook') }}"
                                           class="auth-social-btn auth-social-btn--facebook"
                                        >
                                            <div class="auth-social-btn__label">
                                                <span class="d-none d-lg-inline d-xl-inline">Войти через&nbsp;</span>
                                                Facebook
                                            </div>

                                            <div class="auth-social-btn__icon">
                                                <svg class="symbol-icon social-embed-fb">
                                                    <use xlink:href="/assets/images/icons.svg#social-embed-fb"></use>
                                                </svg>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="auth-socials__item">
                                        <a href="{{ url('login/odnoklassniki') }}"
                                           class="auth-social-btn auth-social-btn--ok"
                                        >
                                            <div class="auth-social-btn__label">
                                                <span class="d-none d-lg-inline d-xl-inline">Войти через&nbsp;</span>
                                                Одноклассники
                                            </div>

                                            <div class="auth-social-btn__icon">
                                                <svg class="symbol-icon social-embed-ok">
                                                    <use xlink:href="/assets/images/icons.svg#social-embed-ok"></use>
                                                </svg>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="auth-socials__item">
                                        <a href="{{ url('login/google') }}"
                                           class="auth-social-btn auth-social-btn--google"
                                        >
                                            <div class="auth-social-btn__label">
                                                <span class="d-none d-lg-inline d-xl-inline">Войти через&nbsp;</span>
                                                Google
                                            </div>

                                            <div class="auth-social-btn__icon">
                                                <svg class="symbol-icon social-embed-google">
                                                    <use xlink:href="/assets/images/icons.svg#social-embed-google"></use>
                                                </svg>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 auth__right">
                        <div class="container">
                            <div class="auth__mobile-or mb-24">
                                Или
                            </div>

                            <div class="auth-form">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="email" class="form-label">Введите E-Mail</label>
                                        <input id="email"
                                               type="email"
                                               class="form-input mb-3{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                               name="email"
                                               value="{{ old('email') }}"
                                               required
                                               autofocus
                                        >

                                        @if ($errors->has('email'))
                                            <span class="form-error">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group mt-24">
                                        <label for="password" class="form-label mt-2">Введите пароль</label>
                                        <input id="password"
                                               type="password"
                                               class="form-input mb-3{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                               name="password"
                                               required
                                        >
                                        @if ($errors->has('password'))
                                            <span class="form-error">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group mt-16">
                                        <label class="form-checkbox">
                                            <input
                                                class="form-checkbox__input"
                                                type="checkbox"
                                                checked="checked"
                                                name="remember" {{ old('remember') ? 'checked' : '' }}
                                            >

                                            <span class="form-checkbox__checkmark"></span>

                                            <span class="form-checkbox__label">
                                                Запомнить этот компьютер
                                            </span>
                                        </label>
                                    </div>

                                    <div class="mt-24">
                                        <button type="submit" class="button button-primary login">
                                            Войти
                                        </button>
                                    </div>

                                    <div class="mt-16">
                                        <a class="link" href="{{ route('password.request') }}">
                                            Забыли пароль?
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="d-none d-md-block auth__bottom">
                <div class="auth-registration-exhortation">
                    <h2 class="title-h2">
                        У вас нет аккаунта?
                    </h2>

                    <div class="title-label mb-24">
                        Ничего страшного, это поправимо. Жмите «Зарегистрироваться».
                    </div>

                    <a href="{{ route('register') }}" class="button button-primary">
                        Зарегистрироваться
                    </a>
                </div>
            </div>
        </div>

        <div class="block-ui mt-24 container d-md-none">
            <div class="auth-registration-exhortation">
                <h2 class="auth__title title-h2">
                    У вас нет аккаунта?
                </h2>

                <div class="auth__title-label">
                    Ничего страшного, это поправимо. Жмите «Зарегистрироваться».
                </div>

                <a href="{{ route('register') }}" class="button button-primary">
                    Зарегистрироваться
                </a>
            </div>
        </div>
    </div>
@endsection
