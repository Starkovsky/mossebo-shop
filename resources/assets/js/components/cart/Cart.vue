<template>
    <div class="cart">
        <div v-if="isEmpty">
            Корзина пуста.
        </div>

        <cart-table
            v-else
            :products.sync="products"
        ></cart-table>


    </div>
</template>

<script>
    import 'axios'

    import CartTable from './CartTable'

    export default {
        name: "Cart",

        components: {
            CartTable
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
