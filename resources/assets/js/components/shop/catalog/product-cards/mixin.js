import Core from '../../../../scripts/core/index'
import FormattedPrice from '../../price/FormattedPrice'
import Rating from '../../../Rating'
import ProductActions from '../../product/ProductActions'
import ProductCardImage from './components/ProductCardImage'

export default {

    components: {
        FormattedPrice,
        Rating,
        ProductActions,
        ProductCardImage
    },

    props: [
        'product',
        'noImageLoading'
    ],

    methods: {
    },

    computed: {
        link() {
            return Core.siteUrl('goods/' + this.product.id)
        }
    }
}
