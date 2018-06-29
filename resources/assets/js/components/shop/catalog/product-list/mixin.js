import { mapState } from 'vuex'

import CatalogProductList from './CatalogProductList'

export default {
    components: {
        CatalogProductList
    },

    // todo: разобраться с таймаутом

    data() {
        return {
            page: 1,
            perPage: 12,

            moreBtn: {
                query: '.js-more-btn',
                eventBinded: false,
                scrollHandler: _.throttle(() => {
                    if (this.canAutoclickMoreBtn()) {
                        this.more()
                    }
                }, 300),
            }

        }
    },

    beforeDestroy() {
        this.unbindScrollMoreEvent()

        if (this.productsLoading.inProcess) {
            this.productsLoading.handler.cancel()
        }
    },

    methods: {
        more() {
            this.page++

            this.calculateProductsToShowThrottler()
        },

        bindScrollMoreEvent() {
            if (this.moreBtn.eventBinded || this.productsToShowCalculateInProcess || !this.moreBtnIsVisible) return

            window.addEventListener('scroll', this.moreBtn.scrollHandler, { passive: true })

            this.$nextTick(() => {
                this.moreBtn.scrollHandler()
            })

            this.moreBtn.eventBinded = true
        },

        unbindScrollMoreEvent() {
            if (this.moreBtn.eventBinded === false) return

            window.removeEventListener('scroll', this.moreBtn.scrollHandler)
            this.moreBtn.eventBinded = false
        },

        canAutoclickMoreBtn() {
            let moreBtn = this.$el.querySelector(this.moreBtn.query)

            if (moreBtn) {
                let screenHeight = document.documentElement.clientHeight
                let coordinates = moreBtn.getBoundingClientRect()

                if (coordinates.top - screenHeight - 500 < 0) {
                    return true
                }
            }

            return false
        }
    },

    computed: {
        moreBtnIsVisible() {
            return this.productsToShow.length < this.productsThatCanBeShown.length
        },
    }
}
