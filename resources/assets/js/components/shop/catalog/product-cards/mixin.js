import Core from '../../../../scripts/core/index'
import FormattedPrice from '../../price/FormattedPrice'
import BackgroundImageLoader from '../../../imageLoaders/BackgroundImageLoader'
import ProductImagesHat from '../../../../mixins/ProductImagesHat'
import Rating from '../../../Rating'
import ProductActions from '../../product/ProductActions'

export default {
    mixins: [
        ProductImagesHat
    ],

    components: {
        FormattedPrice,
        BackgroundImageLoader,
        Rating,
        ProductActions
    },

    props: [
        'product',
    ],

    methods: {
    },

    computed: {
        link() {
            return Core.siteUrl('goods/' + this.product.id)
        }
    }
}
