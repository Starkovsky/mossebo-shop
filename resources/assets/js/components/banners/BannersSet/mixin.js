import Core from '../../../scripts/core/index'
import RequestMixin from '../../../mixins/RequestMixin'
import Banner from '../Banner'

export default {
    mixins: [
        RequestMixin
    ],

    components: {
        Banner
    },

    props: {
        url: null,
        from: null,
    },

    data() {
        return {
            banners: []
        }
    },

    methods: {
        loadBanners() {
            return new Promise(resolve => {
                let banners

                if (this.from) {
                    banners = Core.config(this.from)
                }

                if (banners) {
                    return resolve(banners)
                }

                if (this.url) {
                    return this.sendRequest('get', this.url)
                        .success(response => {
                            resolve(response.data.banners)
                        })
                }

                resolve([])
            })
        },
    },
}
