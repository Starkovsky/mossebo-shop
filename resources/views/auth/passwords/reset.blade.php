@extends('shop.layouts.html')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success mb-24">
                {{ session('status') }}
            </div>
        @endif

        <div class="auth auth--email block-ui">
            <div class="container">
                <h1 class="auth__title title-h1">
                    Восстановление пароля
                </h1>

                <div class="mt-24">
                    <div class="auth-reset mt-32">
                        <form method="POST" action="{{ route('password.request') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="row row--half">
                                <div class="col-12">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="reset-email" class="form-label">
                                            Введите E-Mail
                                        </label>

                                        <input id="reset-email"
                                               type="email"
                                               class="form-input"
                                               name="email"
                                               value="{{ $email or old('email') }}"
                                               required
                                        >

                                        @if ($errors->has('email'))
                                            <span class="form-error">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="reset-password" class="form-label">
                                            Новый пароль
                                        </label>

                                        <input id="reset-password"
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

                                <div class="col-12">
                                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                        <label for="reset-password-confirm" class="form-label">
                                            Подтверждение пароля
                                        </label>

                                        <input id="reset-password-confirm"
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
                                <button type="submit" class="button button-primary auth-reset">
                                    Восстановить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
