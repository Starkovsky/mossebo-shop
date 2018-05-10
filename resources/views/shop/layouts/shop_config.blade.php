@php
    $mossebo_shop_language = \App\Models\Language::with('currency')->first();
@endphp

<script>
    window.mossebo = {
        'language':  {
            'code': "{{ $mossebo_shop_language->code }}",
        },
        'currency': {
            'symbol': "{{ $mossebo_shop_language->currency->symbol }}",
            'swap': "{{ $mossebo_shop_language->currency->swap_currency_symbol }}",
        },
    };

</script>
