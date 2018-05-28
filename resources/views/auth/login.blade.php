@extends('shop.layouts.html')

@section('title', config('app.name', 'Mossebo.Market'))

@section('meta-description', 'description main page')

@section('content')

    <div class="container">
        <div class="auth">
            <div class="row justify-content-center">
                <div class="col-8 col-sm-6 col-md-8">
                    <h1 class="title_h1 text-center">Здравствуйте, войдите</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 auth-social auth-border-bottom">
                    <div class="row justify-content-center">
                        <div class="col-10 col-sm-6 col-md-9 col-lg-8 col-xl-7 pt-0 pt-md-5 pb-5">

                            <a href="{{ url('login/vkontakte') }}"
                               class="auth-social-vk mb-3"
                            >
                                <div class="row justify-content-end align-items-center">
                                    <span class="col-8 col-md-8 col-lg-10">
                                        <div class="d-none d-lg-inline d-xl-inline">Войти через</div>
                                        Вконтакте
                                    </span>
                                    <div class="col-3 col-md-3 col-lg-2">
                                        <svg class="symbol-icon social-embed-vk">
                                            <use xlink:href="/assets/images/icons.svg#social-embed-vk"></use>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ url('login/odnoklassniki') }}"
                               class="auth-social-ok mb-3"
                            >
                                <div class="row justify-content-end align-items-center">
                                    <span class="col-8 col-md-8 col-lg-10">
                                        <div class="d-none d-lg-inline d-xl-inline">Войти через</div>
                                        Одноклассники
                                    </span>
                                    <div class="col-3 col-md-3 col-lg-2">
                                        <svg class="symbol-icon social-embed-ok">
                                            <use xlink:href="/assets/images/icons.svg#social-embed-ok"></use>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ url('login/facebook') }}"
                               class="auth-social-facebook mb-3"
                            >
                                <div class="row justify-content-end align-items-center">
                                    <span class="col-8 col-md-8 col-lg-10">
                                        <div class="d-none d-lg-inline d-xl-inline">Войти через </div>
                                        Facebook
                                    </span>
                                    <div class="col-3 col-md-3 col-lg-2">
                                        <svg class="symbol-icon social-embed-fb">
                                            <use xlink:href="/assets/images/icons.svg#social-embed-fb"></use>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ url('login/google') }}"
                               class="auth-social-google"
                            >
                                <div class="row justify-content-end align-items-center">
                                    <span class="col-8 col-md-8 col-lg-10">
                                        <div class="d-none d-lg-inline d-xl-inline">Войти через </div>
                                        Google
                                    </span>
                                    <div class="col-3 col-md-3 col-lg-2">
                                        <svg class="symbol-icon social-embed-google">
                                            <use xlink:href="/assets/images/icons.svg#social-embed-google"></use>
                                        </svg>
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>

                </div>
                <div class="col-md-6 auth-form auth-border-bottom">
                    <div class="row justify-content-center">
                        <div class="col-10 col-sm-6 col-md-9 col-lg-8 col-xl-6 py-5">
                            <form method="POST" action="{{ route('login') }}">

                                @csrf

                                <label for="email" class="form-label">Введите E-Mail</label>
                                <input id="email"
                                       type="email"
                                       class="form-input mb-3 {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       autofocus
                                >
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                                <label for="password" class="form-label mt-2">Введите пароль</label>
                                <input id="password"
                                       type="password"
                                       class="form-input mb-3 {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                       name="password"
                                       required
                                >
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                                <label class="form-checkbox mb-3">
                                    Запомнить этот компьютер
                                    <input type="checkbox"
                                           checked="checked"
                                           name="remember" {{ old('remember') ? 'checked' : '' }}
                                    >
                                    <span class="checkmark"></span>
                                </label>

                                <div class="text-center">
                                    <button type="submit" class="button button-primary login">
                                        Войти
                                    </button>
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Забыли пароль?
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="py-5 text-center">
                        <h2 class="title_h2 mb-4">У вас нет аккаунта?</h2>
                        <div class="title-label mb-4">Ничего страшного. Это поправимо. Жмите «регистрация».</div>
                        <a href="{{ route('register') }}" class="button button-primary">
                            Зарегистрироваться
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
