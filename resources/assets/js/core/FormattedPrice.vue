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
                return value.toLocaleString();
            },
        },
    }
</script>

<style lang="scss" scoped>

</style>
