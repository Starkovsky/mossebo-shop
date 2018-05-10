@extends('shop.layouts.html')

@section('title', config('app.name', 'Laravel'))

@section('meta-description', 'description main page')


@section('content')

    <div class="container py-5">
        <div class="error-404">
            <div class="row">
                <div class="col-md-4">
                    <div class="error-404__code">404</div>
                </div>
                <div class="col-md-8">
                    <h1 class="title_h2">Страница не найдена</h1>
                    <p>
                        К сожалению, запрашиваемая вами веб-страница не найдена. <br>
                        Вы всегда можете найти интересующий вас товар, воспользовавшись поисковым полем в меню сайта или или воспользоваться каталогом товаров.
                    </p>
                    <a href="/" class="button button-light"><i class="md-icon mr-3">arrow_back</i>Главная страница</a>
                </div>
            </div>
        </div>
    </div>

@endsection
