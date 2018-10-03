import RequestMixin from '../../../mixins/RequestMixin'
import DataHandler from '../../../scripts/DataHandler'
import Banner from '../Banner'

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

            let place = parseInt(this.place)

            banners = banners.filter(item => {
                return item.places.indexOf(place) !== -1
            })

            this.banners = _.shuffle(banners).slice(0, this.quantity)
        }
    },
}
