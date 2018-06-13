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
                        <h2 class="title_h3">Как мне вернуть товар?</h2>
                        <p>По любым вопросам возврата товара вы можете обращаться по:</p>
                        <ul>
                            <li>телефону +7 (812) 612-48-19 каждый день с 9:00 до 20:00 по московскому времени</li>
                            <li>электронной почте <a href="mailto:help@mossebo.market">help@mossebo.market</a></li>
                            <li>в сообщениях в группе Вконтакте</li>
                            <li>Direct сообщениях в instagram @remont.design</li>
                        </ul>
                    </div>
                    <div class="faq__item">
                        <h2 class="title_h3">Какие условия возврата?</h2>
                        <p>В случае полного либо частичного отказа от предметов в момент присутствия нашего курьера - вам необходимо оплатить стоимость доставки и подъема.</p>
                    </div>
                    <div class="faq__item">
                        <h2 class="title_h3">В какие сроки осуществляется возврат?</h2>
                        <p>Товар можно вернуть в течение 7 календарных дней с даты получения.</p>
                    </div>
                    <div class="faq__item">
                        <h2 class="title_h3">Какие товары не подлежат возврату?</h2>
                        <p>Вернуть нельзя товары следующие покупки:</p>
                        <ul>
                            <li>Постельное белье</li>
                            <li>Товары по индивидуальным размерам и с возможностью выбора материала</li>
                            <li>Мебель и аксессуары после сборки</li>
                            <li>Мебель и аксессуары без фабричной упаковки и товарного/кассового чека</li>
                        </ul>
                    </div>
                    <div class="faq__item">
                        <h2 class="title_h3">Как осуществляется возврат?</h2>
                        <p>Вернуть товар можно только с помощью курьерской службы mossebo.market. При оформлении возврата необходимо заполнить заявление, прикрепить к нему документы о покупке (накладная, акт приема, чеки) и передать их вместе с курьером.</p>
                    </div>
                    <div class="faq__item">
                        <h2 class="title_h3">Сроки зачисления средств</h2>
                        <p>Срок возврата денежных средств составляет 7 рабочих дней после получения нами правильно оформленного и подписанного заявления.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-2"></div>
@endsection
