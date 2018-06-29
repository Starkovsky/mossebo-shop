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

                <div class="auth__title-label">
                    Мы пришлем вам ссылку на восстановление пароля
                </div>

                <div class="mt-24">
                    <div class="auth-forgotten mt-32">
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                <label for="forgotten-email" class="form-label">
                                    Введите E-Mail
                                </label>

                                <input id="forgotten-email"
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

                            <div class="mt-24">
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
