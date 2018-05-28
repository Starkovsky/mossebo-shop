@extends('shop.layouts.html')

@section('title', config('app.name', 'Mossebo.Market'))

@section('meta-description', 'description main page')

@section('content')

    <div class="container">
        <div class="auth">

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row justify-content-center auth-social auth-border-bottom pb-5">
                    <div class="col-md-6">
                        <h1 class="title_h1 text-center">Создание аккаунта</h1>
                        <div class="title-label mb-4">Аккаунт позволит вам добавлять товары в избранное, отслеживать
                            заказы, а также получать скидки, специальные предложения.
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
                            <div class="row justify-content-center">
                                <div class="col-sm-6">
                                    <div class="row align-items-center">
                                        <div style="background-image: url({{ $socialUser->getAvatar() }});"
                                             class="auth-avatar">
                                        </div>
                                        <div class="auth-name">{{ $socialUser->getName() }}</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center">
                                <a href="{{ url('login/vkontakte') }}"
                                   class="auth-social-vk cricle mb-3"
                                >
                                    <svg class="symbol-icon social-embed-vk">
                                        <use xlink:href="/assets/images/icons.svg#social-embed-vk"></use>
                                    </svg>
                                </a>
                                <a href="{{ url('login/odnoklassniki') }}"
                                   class="auth-social-ok cricle mb-3"
                                >
                                    <svg class="symbol-icon social-embed-ok">
                                        <use xlink:href="/assets/images/icons.svg#social-embed-ok"></use>
                                    </svg>
                                </a>
                                <a href="{{ url('login/facebook') }}"
                                   class="auth-social-facebook cricle mb-3"
                                >
                                    <svg class="symbol-icon social-embed-fb">
                                        <use xlink:href="/assets/images/icons.svg#social-embed-fb"></use>
                                    </svg>
                                </a>
                                <a href="{{ url('login/google') }}"
                                   class="auth-social-google cricle mb-3"
                                >
                                    <svg class="symbol-icon social-embed-google">
                                        <use xlink:href="/assets/images/icons.svg#social-embed-google"></use>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="py-5 auth-form">
                    <div class="row justify-content-center">
                        <div class="col-10 col-sm-10 col-md-9 col-lg-6">
                            <div class="row">

                                <div class="col-sm-6 mb-3">
                                    <label for="name" class="form-label">Имя</label>
                                    <input id="name"
                                           type="text"
                                           class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                           name="name"
                                           value="{{ old('name') }}"
                                           required
                                           autofocus
                                    >
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label for="last_name" class="form-label">Фамилия</label>
                                    <input id="last_name"
                                           type="text"
                                           class="form-input {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                           name="last_name"
                                           value="{{ old('last_name') }}"
                                           required
                                           autofocus
                                    >
                                    @if ($errors->has('last_name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label for="phone" class="form-label">Телефон</label>
                                    <input id="phone"
                                           type="phone"
                                           class="form-input {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                           name="phone"
                                           value="{{ old('phone') }}"
                                           required
                                    >
                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label for="email" class="form-label">E-Mail</label>
                                    <input id="email"
                                           type="email"
                                           class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                    >
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="password" class="form-label">Пароль</label>
                                    <input id="password"
                                           type="password"
                                           class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                           name="password"
                                           required
                                    >
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="password-confirm" class="form-label">Подтверждение пароля</label>
                                    <input id="password-confirm"
                                           type="password"
                                           class="form-input"
                                           name="password_confirmation"
                                           required
                                    >
                                </div>
                            </div>

                            <div class="text-center py-4">
                                <button type="submit" class="button button-primary login">
                                    Создать
                                </button>
                            </div>
                            <div class="title-label">
                                Нажимая кнопку «Создать аккаунт», я соглашаюсь с условиями
                                <a href="#">пользовательского соглашения</a>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{--<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

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
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
@endsection
