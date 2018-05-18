<template>
    <table v-if="products.length" class="cart-table">
        <thead v-if="!noHeader">
            <tr>
                <th colspan="2">
                    Товары
                </th>

                <th>
                    Количество
                </th>

                <th>
                    Цена за штуку
                </th>

                <th>
                    Цена
                </th>

                <th></th>
            </tr>
        </thead>

        <tbody>
            <template v-for="product in products">
                <cart-product
                    :product="product"
                    :quantity.sync="product.quantity"
                    @remove="remove(product.id)"
                ></cart-product>
            </template>
        </tbody>
    </table>

    <div v-else class="">
        Товар
    </div>
</template>

<script>
    import CartProduct from './CartProduct'

    export default {
        name: "CartTable",

        components: {
            CartProduct
        },

        props: {
            'no-header': {
                type: Boolean,
                default: false,
            },

            products: {
                type: Array,
                default: () => []
            }
        },

        methods: {
            remove(productId) {
                this.$emit('update:products', this.products.filter(product => product.id !== productId))
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import "../../../../sass/variables/colors";

    .cart-table {
        & th {
            font-size: 16px / 19px;
            text-align: left;

            &:not(:first-child) {
                text-align: center;
            }

            color: $color-text-secondary-2;
        }
    }

</style>
