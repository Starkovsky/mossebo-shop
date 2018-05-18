<template>
    <div v-if="isEmpty">
        Корзина пуста.
    </div>

    <div v-else>
        <checkout-steps
            active="cart"
        ></checkout-steps>

        <div class="py-3"></div>

        <div class="cart bulge">
            <cart-table
                :products.sync="products"
            ></cart-table>
        </div>
    </div>
</template>

<script>
    import 'axios'

    import CartTable from './CartTable'
    import CheckoutSteps from '../CheckoutSteps'

    export default {
        name: "Cart",

        components: {
            CartTable,
            CheckoutSteps
        },

        data() {
            return {
                products: [
                    {
                        ... this.$root.ActionProduct,
                        category: 'Ковры',
                        quantity: 1,
                    }
                ]
            }
        },

        methods: {
            fetchProductsData() {
                return axios.post('/api/cart/data', this.productsIds)
                    .then(function (response) {
                        this.products = response.products
                    })
                    .catch(function (error) {
                        // todo: попробовать снова, или выдать сообщение об ошибке
                        console.log(error);
                    });
            },


        },

        computed: {
            isEmpty() {
                console.log(this.products)
                return !this.products.length
            },

            total() {
                return this.products.reduce((acc, product) => {
                    acc += product.quantity * product.price

                    return acc
                }, 0)
            }
        }
    }
</script>

<style scoped>

</style>
