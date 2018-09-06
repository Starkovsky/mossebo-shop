import RequestMixin from '../../../mixins/RequestMixin'
import Banner from '../Banner'
import DataHandler from '../../../scripts/DataHandler'

export default {
    mixins: [
        RequestMixin
    ],

    components: {
        Banner
    },

    props: [
        'place',
        'quantity'
    ],

    data() {
        return {
            banners: []
        }
    },

    methods: {
        loadBanners() {
            return DataHandler.get('banners')
                .then(({banners}) => {
                    this.setBanners(banners)
                })
        },

        setBanners(banners) {
            if (! banners) return

            this.banners = _.shuffle(banners).slice(0, this.quantity)
        }
    },
}
