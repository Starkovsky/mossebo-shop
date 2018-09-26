<template>
    <span v-if="typeof value !== 'undefined'">
        {{ formatted }}
    </span>
</template>

<script>
    import Core from '../../../scripts/core'

    export default {
        name: "FormattedPrice",

        props: [
            'value',
        ],

        computed: {
            formatted() {
                let value = this.value.toString().replace(',', '.').replace(/[^0-9]+/g, '')

                return parseFloat(value).toLocaleString(undefined, {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 0,
                    currencyDisplay: 'symbol',
                    style: 'currency',
                    currency: Core.config('currency.code')
                })
            }
        }
    }
</script>
