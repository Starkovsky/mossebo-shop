<template>
    <span v-if="typeof value !== 'undefined'">
        {{ formatted }}
    </span>
</template>

<script>
    export default {
        name: "FormattedPrice",

        props: [
            'value',
        ],

        computed: {
            formatted() {
                let value = this.value.toString().replace(',', '.').replace(/[^0-9]+/g, '')
                return parseFloat(value).toLocaleString() + ' ' + this.$root.mossebo.currency.symbol
            }
        }
    }
</script>
