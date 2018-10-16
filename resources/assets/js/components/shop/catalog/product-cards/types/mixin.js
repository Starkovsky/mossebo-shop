import { mapGetters } from 'vuex'
import Core from '../../../../../scripts/core/index'
import FormattedPrice from '../../../price/FormattedPrice'
import Rating from '../../../../Rating'
import ProductActions from '../../../product/ProductActions'
import ProductCardImage from '../components/ProductCardImage'
import ProductCardButton from '../components/ProductCardButton'
import Badges from '../../../badges/Badges'

export default {
    components: {
        FormattedPrice,
        Rating,
        ProductActions,
        ProductCardImage,
        ProductCardButton,
        Badges
    },

    props: [
        'product',
        'noImageLoading'
    ],

    data() {
        return {
            currentImage: 0
        }
    },

    methods: {
        showImage: function (n) {
            this.currentImage = n;
        },

        addToCart() {
            this.$store.dispatch('cart/addProduct', [{id: this.product.id}, 1])
                .then(() => Core.metrika.reachGoal('add-to-cart'))
        }
    },

    computed: {
        link() {
            return Core.siteUrl('goods/' + this.product.id)
        },

        ... mapGetters({
            cartProducts: 'cart/products'
        }),

        inCart() {
            return !! this.cartProducts.find(item => item.id.toString() === this.product.id.toString())
        },


        maxPrice() {
            return this.product.getMaxPrice()
        },

        minPrice() {
            return this.product.getMinPrice()
        },

        discountPercent() {
            return '-&thinsp;' + this.product.getDiscountPercent() + '&thinsp;%'
        },

        discount() {
            return this.product.getDiscount()
        },
    }
}
