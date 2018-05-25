import PendingLoader from '../../../../scripts/PendingLoader'

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
            productsLoading: {
                inProcess: false,
                minTime: 700,
                handler: false
            },

            moreBtn: {
                query: '.js-more-btn',
                scrollHandler: false,
                handlerTimeout: null,
                delayTimeout: null
            }

        }
    },

    beforeDestroy() {
        this.unbindScrollMoreEvent()
        clearTimeout(this.moreBtn.delayTimeout)

        if (this.productsLoading.inProcess) {
            this.productsLoading.handler.cancel()
        }
    },

    methods: {
        loadingProductsStart() {
            if (this.productsLoading.inProcess) {
                this.productsLoading.handler.cancel()
            }

            this.productsLoading = {
                inProcess: true,
                minTime: this.productsLoading.minTime,
                handler: new PendingLoader(this.productsLoading.minTime)
            }
        },

        loadingProductsEnd() {
            if (this.productsLoading.inProcess) {
                this.productsLoading.handler.finish(() => {
                    this.productsLoading = {
                        inProcess: false,
                        minTime: this.productsLoading.minTime,
                        handler: false
                    }
                })
            }
        },

        more() {
            this.page++

            this.moreBtn.delayTimeout = setTimeout(() => {
                this.bindScrollMoreEvent()
            }, 300)
        },

        bindScrollMoreEvent() {
            if (!this.moreBtnIsVisible || this.moreBtn.scrollHandler !== false) return

            if (this.canAutoclickMoreBtn()) {
                this.more()
                return
            }

            this.moreBtn.scrollHandler = () => {
                if (this.moreBtn.handlerTimeout) return

                this.moreBtn.handlerTimeout = setTimeout(() => {
                    if (this.canAutoclickMoreBtn()) {
                        this.unbindScrollMoreEvent()
                        this.more()
                    }

                    this.moreBtn.handlerTimeout = false
                }, 60)
            }

            window.addEventListener('scroll', this.moreBtn.scrollHandler, { passive: true })
        },

        unbindScrollMoreEvent() {
            if (this.moreBtn.scrollHandler === false) return
            clearTimeout(this.moreBtn.handlerTimeout)

            window.removeEventListener('scroll', this.moreBtn.scrollHandler)

            this.moreBtn.scrollHandler = false
        },

        resetPage() {
            this.page = 1
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
        productsToShow() {
            let end = Math.min(this.perPage * this.page, this.productsThatCanBeShown.length)

            return this.productsThatCanBeShown.slice(0, end)
        },

        moreBtnIsVisible() {
            return this.productsToShow.length < this.productsThatCanBeShown.length
        }
    }
}
