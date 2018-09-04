export default {
    data() {
        return {
            sliderEl$: null,
            sliderInited: false
        }
    },

    methods: {
        makeSlider() {
            this.sliderEl$ = $(this.$el.querySelector('.js-slider'))

            if (! this.sliderEl$.length) return

            this.handleDebouncer = _.debounce(this.handleResize, 300)

            this.$root.$on('resize', this.handleDebouncer)

            this.$nextTick(() => {
                this.handleResize()
            })
        },

        initSlider() {
            if (this.sliderInited) return

            this.sliderEl$.slick(
                this.getSliderSettings()
            );

            this.sliderInited = true
        },

        destroySlider() {
            if (! this.sliderInited) return

            this.sliderEl$.slick('unslick')

            this.sliderInited = false
        },

        handleResize() {
            if (this.needsToDestroySlider()) {
                this.destroySlider()
            }
            else {
                this.initSlider()
            }
        },

        needsToDestroySlider() {
            return this.$root.windowMoreThan('lg')
        },

        getSliderSettings() {
            return {

            }
        }
    }
}
