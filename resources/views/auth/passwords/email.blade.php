@extends('shop.layouts.html')

@section('title', config('app.name', 'Mossebo.Market'))

@section('meta-description', 'description main page')

@section('content')

    <div class="container">
        <div class="auth">

            <div class="row justify-content-center">
                <div class="col-10 pb-0 pb-md-5">
                    <h1 class="title_h1 text-center">Восстановление пароля</h1>
                    <div class="title-label mb-5">Мы пришлем вам ссылку на восстановление пароля</div>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row justify-content-center pb-5">
                        <div class="col-10 col-md-8 col-lg-6">
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <label for="email" class="form-label">Введите E-Mail</label>
                                <input id="email"
                                       type="email"
                                       class="form-input mb-4 {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                >
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                                <div class="text-center">
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
    </div>

@endsection
