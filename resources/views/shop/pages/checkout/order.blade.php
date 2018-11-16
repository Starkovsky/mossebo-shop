@extends('shop.layouts.html')

@section('content')
    <div class="container">
        <h1 class="title-h1">
            Заказ №{{ $orderId }}
        </h1>

        <order-info
            class="block-ui"
            :order="{{ json_encode($order, JSON_UNESCAPED_UNICODE) }}"
        ></order-info>

        @if ($order['status']['id'] == 1)
            <div class="mt-32">
                <a href="{{ siteUrl("/checkout/order/$orderId/pay") }}" class="button button-primary">
                    Оплатить
                </a>
            </div>
        @endif
    </div>
@endsection
