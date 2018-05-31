import { mapGetters, mapState } from 'vuex'
import CartTable from './CartTable'
import FormattedPrice from '../price/FormattedPrice'
import Loading from '../../../components/Loading'
import PendingLoader from '../../../scripts/PendingLoader'

export default {
    components: {
        CartTable,
        FormattedPrice,
        Loading
    },

    data() {
        return {
            loading$: false,
            pendingLoader: false
        }
    },

    watch: {
        loading() {
            // если ответ с сервера приходит менее чем за 100мс - никакой анимации загрузки не будет.
            // если больше - включается загрузка, которая продлится не менее чем 300мс, чтобы избежать мигания.
            if (this.loading) {
                this.startLoadingDebounce()
            }
            else {
                this.stopLoadingDebounce()
            }
        }
    },

    created() {
        this.$store.dispatch('cart/init')

        this.startLoadingDebounce = _.debounce(() => {
            this.startInnerLoading()
        }, 100)

        this.stopLoadingDebounce = _.debounce(() => {
            this.stopInnerLoading()
        }, 100)
    },

    methods: {
        refresh() {
            this.$store.dispatch('cart/refresh')
        },

        startInnerLoading() {
            if (!this.loading) return
            if (this.pendingLoader !== false) {
                this.pendingLoader.cancel()
            }
            this.pendingLoader = new PendingLoader(300)
            this.loading$ = true
        },

        stopInnerLoading() {
            if (this.loading) return
            if (this.pendingLoader === false) return

            this.pendingLoader.finish(() => {
                this.loading$ = false
                this.pendingLoader = false
            })
        }
    },

    computed: {
        ... mapGetters({
            productsQuantity: 'cart/quantity',
        }),

        ... mapState({
            loading: state => state.cart.loading,
            hasError: state => state.cart.error,
            isReady: state => state.cart.ready,
            isEmpty: state => !state.cart.items.length,
            productsPrice: (state, getters) => {
                return getters['cart/products'].reduce((acc, product) => {
                    acc += product.quantity * product.price

                    return acc
                }, 0)
            }
        }),

        shippingPrice() {
            return 0
        },

        totalPrice() {
            return this.productsPrice + this.shippingPrice
        },
    }
}
