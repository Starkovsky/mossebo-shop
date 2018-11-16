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
                :value="product.price"
            ></formatted-price>
        </td>

        <td>
            <span class="order-table__qty">
                {{ product.quantity }}&nbsp;шт
            </span>
        </td>

        <td>
            <formatted-price
                v-if="totalPrice"
                class="order-table__price"
                :value="totalPrice"
            ></formatted-price>
        </td>
    </tr>
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
