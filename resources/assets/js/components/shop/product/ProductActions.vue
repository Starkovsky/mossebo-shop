<template>
    <div class="product-actions">
        <div class="product-actions__container">
            <div class="product-actions__item">
                <a
                    @click="addToComparison(productId)"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Сравнение"
                >
                    <svg class="symbol-icon symbol-wishlist">
                        <use xlink:href="/assets/images/icons.svg#symbol-comparison"></use>
                    </svg>
                </a>
            </div>

            <div class="product-actions__item">
                <a href="javascript:void(0);"
                   data-toggle="tooltip"
                   data-placement="top"
                   title="Данная функция в разработке"
                >
                    <svg class="symbol-icon symbol-heart">
                        <use xlink:href="/assets/images/icons.svg#symbol-heart"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ProductActions",

        props: [
            'productId'
        ],

        mounted() {
            this.$root.initTooltips()
        },

        methods: {
            addToComparison(productId) {
                this.$store.dispatch('comparison/add', productId)
            }
        }
    }
</script>
