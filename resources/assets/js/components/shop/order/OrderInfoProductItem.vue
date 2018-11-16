<template>
    <div class="order-product-item">
        <div class="order-product-item__top">
            <product-short-description
                :product="product"
            ></product-short-description>
        </div>

        <div class="order-product-item__bottom">
            <div class="order-product-item__price">
                <formatted-price
                    :value="product.price"
                ></formatted-price>
            </div>

            <div class="order-product-item__num">
                {{ product.quantity }}&nbsp;шт
            </div>

            <div class="order-product-item__total">
                <formatted-price
                    v-if="totalPrice"
                    :value="totalPrice"
                ></formatted-price>
            </div>
        </div>
    </div>
</template>

<script>
    import ProductShortDescription from '../ProductShortDescription'
    import FormattedPrice from '../price/FormattedPrice'

    export default {
        name: "CabinetOrderProductRow",

        components: {
            ProductShortDescription,
            FormattedPrice
        },

        props: {
            product: Object,
        },

        computed: {
            totalPrice() {
                return this.product.quantity * this.product.price
            },
        }
    }
</script>
