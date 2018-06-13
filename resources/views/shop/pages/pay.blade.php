@extends('shop.layouts.html')

@section('title', config('app.name', 'Laravel'))

@section('meta-description', 'description main page')


@section('content')
    <div class="container mb-4">
        <h1 class="title_h1">
            Раздел для покупателей
        </h1>
    </div>
    <div class="container faq pb-md-4">
        <div class="block-ui">
            <div class="row">
                <div class="col-4 p-5">
                    @include('shop.layouts.faq-sub-nav')
                </div>
                <div class="col-8 faq__border-left">
                    <div class="faq__item">
                        <h2 class="title_h3">Когда можно оплатить заказ?</h2>
                        <p>Оплатить товары mossebo.market можно сразу после подтверждения заказа от менеджера.</p>
                    </div>
                    <div class="faq__item">
                        <h2 class="title_h3">Чем можно оплатить?</h2>
                        <p>Все платежи осуществляются через сервис Яндекс.Касса. Ваши карты и деньги надежно защищены и не попадут в руки мошенников.</p>
                        <ul>
                            <li>Банковской картой или электронными деньгами на сайте после подтверждения заказа</li>
                            <li>Безналичный перевод на счет ООО "Моссэбо КМ" – счет придет на почту после согласования заказа</li>
                            <li>Электронными деньгами (Яндекс.Деньги, Qiwi, Web Money)</li>
                            <li>Apple Pay</li>
                            <li>Наличными</li>
                        </ul>
                    </div>
                    <div class="faq__item">
                        <h2 class="title_h3">Почему нельзя оплатить наложным платежом</h2>
                        <p>Большинство товаров mossebo.market изготоваливаются на заказ, с индивидуальными размерами и материалами. Поэтому все заказы в mossebo.market осуществляются только после 100% предоплаты.</p>
                    </div>
                    <div class="faq__item">
                        <h2 class="title_h3">Как может оплатить юридическое лицо?</h2>
                        <p>Касса подходит для ИП и юр. лиц, работает в России и за её пределами.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-2"></div>
@endsection
