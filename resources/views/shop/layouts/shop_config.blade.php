@php
    $mossebo_shop_language = \App\Models\Language::with('currency')->first();

@endphp

<script>
    window.mossebo = {
        'language': "{{ $mossebo_shop_language->code }}",
        'currency_symbol': "{{ $mossebo_shop_language->currency->symbol }}",
        'currency_swap': "{{ $mossebo_shop_language->currency->swap_currency_symbol }}",
    };
</script>
