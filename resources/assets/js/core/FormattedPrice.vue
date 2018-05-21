<template>
    <span v-if="price != undefined">
        {{ PriceWithSeparation( price ) }} {{ this.$root.mossebo.currency.symbol }}
    </span>
</template>

<script>
    export default {
        name: "FormattedPrice",
        props: [
            'price',
        ],
        methods: {
            PriceWithSeparation: function (value) {
                value = value.toString().replace(',', '.').replace(/[^0-9]+/g, '')
                return parseFloat(value).toLocaleString()
            },
        },
    }
</script>
