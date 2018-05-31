export default  {
    props: {
        image: null,
        retinaImage: null,
        screen: {
            type: Boolean,
            default: false,
        },
        offset: {
            type: Number,
            default: 1000
        },
        index: Number
    },

    data() {
        return {
            loaded: false,
            animate: false,
            // todo: протестировать в ie
            image$: 'data:image/svg+xml;base64,' + btoa('<svg xmlns="http://www.w3.org/2000/svg"></svg>'),
        }
    },

    methods: {
        isLoaded(elImg) {
            if (! elImg.complete) {
                return false
            }

            if (typeof elImg.naturalWidth !== 'undefined' && elImg.naturalWidth === 0) {
                return false
            }

            return true
        },

        onLoad(elImg, cb) {
            if (typeof cb !== 'function') return

            if (this.isLoaded(elImg)) {
                this.animate = false

                cb()
            }
            else {
                this.animate = true

                let onLoad = () => {
                    elImg.removeEventListener('load', onLoad)
                    cb()
                }

                elImg.addEventListener('load', onLoad)
            }
        },

        getResponsiveImage() {
            if (isHighDensity() && !_.isEmpty(this.retinaImage)) {
                return this.retinaImage
            }

            return _.isString(this.image) ? this.image : ''
        },

        load() {
            let elImg = document.createElement('img')
            elImg.src = this.getResponsiveImage()

            this.onLoad(elImg, () => {
                this.loaded = true
                this.image$ = this.image
            })
        },

        isNeedToShow() {
            let screenHeight = document.documentElement.clientHeight
            let coordinates = this.$el.getBoundingClientRect()

            if (coordinates.top - screenHeight - this.offset > 0) {
                return false
            }

            if (coordinates.top + this.$el.scrollHeight + this.offset < 0) {
                return false
            }

            return true
        },

        bindEvents() {
            this.handler = () => {
                clearTimeout(this.timeout)

                this.timeout = setTimeout(() => {
                    if (this.isNeedToShow()) {
                        this.load()
                        this.unbindEvents()
                    }
                }, 60)
            }

            window.addEventListener('scroll', this.handler, { passive: true })
            document.addEventListener('DOMSubtreeModified', this.handler)
        },

        unbindEvents() {
            if (! this.handler) return

            window.removeEventListener('scroll', this.handler)
            document.removeEventListener('DOMSubtreeModified', this.handler)

            this.handler = false
        },

        init() {
            if (this.loaded || this.handler) return

            this.$nextTick(() => {
                if (!screen || this.isNeedToShow()) {
                    this.load()
                }
                else {
                    this.bindEvents()
                }
            })
        }
    },

    created() {
        this.init()
    },

    beforeDestroy() {
        this.unbindEvents()
    }
}

