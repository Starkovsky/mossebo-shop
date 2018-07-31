@component('mail::row', ['class' => 'product-row row-fw'])
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="checkout-table">
        <tbody>
            @foreach($products as $key => $product)
                <tr>
                    @if ($product['image'])
                        <td style="width: 112px">
                            <div class="product-image">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td align="center">
                                            <a href="{{ $product['url'] }}">
                                                <img src="{{ $product['image'] }}" alt="{{ $product['title'] }}" width="">
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    @else
                        <td>

                        </td>
                    @endif

                    <td style="text-align: left">
                        <a href="{{ $product['url'] }}">
                            <span class="checkout-product-name">
                                {{ $product['title'] }}
                            </span>
                        </a>
                    </td>

                    <td style="text-align: center">
                        <span class="price">
                            {{ $product['quantity'] }} x {{ $product['price'] }}
                        </span>
                    </td>

                    <td style="text-align: right">
                        <span class="price">
                            {{ $product['total'] }}
                        </span>
                    </td>
                </tr>
            @endforeach

            <tr>
                <td colspan="3" style="text-align: right; padding-right: 16px">
                    <strong>{{ trans('shop.checkout.total') }}:</strong>
                </td>

                <td style="text-align: right">
                    <span class="price">
                        <strong>{{ $total }}</strong>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
@endcomponent
