@foreach($products as $product)
    {{ $product['title'] }}: {{ $product['url'] }}
@endforeach

#### {{ trans('shop.checkout.total') }}: {{ $total }}
