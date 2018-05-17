@extends('shop.layouts.html')

@section('title', config('app.name', 'Mossebo.Market'))

@section('meta-description', 'description main page')

@section('content')

<div class="container">
    <div class="auth">
        <h1 class="title_h1 text-center">Здравствуйте, войдите</h1>
        <div class="row align-middle">
            <div class="col-sm-6 auth-social">
                <a href="{{ url('login/vkontakte') }}" target="_blank">VK Login</a>
            </div>
            <div class="col-sm-6 auth-form">
                <div class="row justify-content-center">
                    <div class="col-xl-6 py-5">
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
        <div class="pt-5 text-center">
            <h2 class="title_h2 mb-4">У вас нет аккаунта?</h2>
            <div class="title-label mb-4">Ничего страшного. Это поправимо. Жмите «регистрация».</div>
            <a href="{{ route('register') }}" class="button button-primary">
                Зарегистрироваться
            </a>
        </div>
    </div>
</div>

{{--<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>--}}
@endsection
