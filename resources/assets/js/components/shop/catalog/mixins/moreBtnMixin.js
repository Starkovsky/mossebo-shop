import { mapState } from 'vuex'

export default {
    data() {
        return {
            moreBtn: {
                query: '.js-more-btn',
                eventBinded: false,
                scrollHandler: _.throttle(() => {
                    if (this.canAutoclickMoreBtn()) {
                        this.more()
                    }
                }, 128),
            }
        }
    },

    computed: {
        ... mapState({
            moreBtnIsVisible: state => {
                return state.catalog.activeProductIndexes.length > state.catalog.pagination.productsToShow.length
            },
        })
    },

    watch: {
        paginating: 'handleEvents'
    },

    mounted() {
        this.eventBinderDebouncer = _.debounce(this.bindScrollMoreEvent, 300)
    },

    methods: {
        more() {
            this.$store.dispatch('catalog/more')
        },

        handleEvents() {
            if (!this.paginating) {
                this.eventBinderDebouncer()
            }
        },

        bindScrollMoreEvent() {
            if (this.moreBtn.eventBinded || !this.moreBtnIsVisible) return

            window.addEventListener('scroll', this.moreBtn.scrollHandler, { passive: true })

            this.moreBtn.eventBinded = true
            this.moreBtn.scrollHandler()
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
                    this.unbindScrollMoreEvent()
                    return true
                }
            }

            return false
        }
    },

    beforeDestroy() {
        this.unbindScrollMoreEvent()
    },
}
