<template>
    <tr>
        <td>
            <product-short-description
                :product="product"
            ></product-short-description>
        </td>

        <td>
            <formatted-price
                class="order-table__price"
                :value="product.finalPrice"
            ></formatted-price>
        </td>

        <td>
            <span class="order-table__qty">
                {{ product.quantity }}&nbsp;шт
            </span>
        </td>

        <td>
            <span class="order-table__price">
                <formatted-price
                    v-if="totalPrice"
                    :value="totalPrice"
                ></formatted-price>
            </span>
        </td>
    </tr>
</template>

<script>
    import ProductShortDescription from '../../../ProductShortDescription'
    import FormattedPrice from '../../../price/FormattedPrice'

    export default {
        name: "OrderProductRow",

        components: {
            ProductShortDescription,
            FormattedPrice
        },

        props: {
            product: Object,
        },

        computed: {
            totalPrice() {
                return this.product.quantity * this.product.finalPrice
            },
        }
    }
</script>
