import FormattedPrice from '../../price/FormattedPrice'
import NumControl from '../../../NumControl'
import ProductShortDescription from '../../ProductShortDescription'

export default {

    components: {
        FormattedPrice,
        NumControl,
        ProductShortDescription
    },

    props: {
        product: Object,
        small: Boolean,
        noControls: Boolean
    },

    data() {
        return {
            /**
             * интервал, нужный для обработки зажимания кнопок +/-
             */
            quantityFlowInterval: null,

            /**
             * таймаут, который увеличивает запускает интервал,
             * чтобы при единичном клике не было изменения количества товаров на несколько шт.
             */
            quantityFlowTimeout: null,
        }
    },

    methods: {
        remove() {
            this.$store.dispatch('cart/removeProduct', this.product)
            // this.$emit('remove', this)
        },

        getDescEl(e) {
            return e.target.closest('.js-product-description')
        },

        changeQty(qty) {
            this.$store.dispatch('cart/updateProduct', [this.product, qty])
        }
    },

    computed: {
        totalPrice() {
            return this.product.quantity * this.product.price
        },

        isGhost() {
            return this.product.quantity === 0
        },
    }
}
