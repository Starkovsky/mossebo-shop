import { mapGetters, mapState } from 'vuex'
import CartTable from './CartTable'
import FormattedPrice from '../price/FormattedPrice'
import Loading from '../../../components/Loading'

export default {
    components: {
        CartTable,
        FormattedPrice,
        Loading
    },

    mounted() {
        this.$store.dispatch('cart/init')
    },

    methods: {
        refresh() {
            this.$store.dispatch('cart/refresh')
        },
    },

    computed: {
        isEmpty() {
            return !this.products.length
        },

        productsQuantity() {
            return this.products.reduce((acc, product) => {
                acc += product.quantity

                return acc
            }, 0)
        },

        productsPrice() {
            return this.products.reduce((acc, product) => {
                acc += product.quantity * product.price

                return acc
            }, 0)
        },

        shippingPrice() {
            return 0
        },

        totalPrice() {
            return this.productsPrice + this.shippingPrice
        },

        ... mapGetters({products: 'cart/products'}),

        ... mapState({
            loading: state => state.cart.loading,
            hasError: state => state.cart.error,
            isReady: state => state.cart.ready,
        })
    }
}
