export default {
    props: {
        filter: null,
        expanded: {
            type: Boolean,
            default: true
        }
    },

    mounted() {
        this.$nextTick(() => {
            heightToggle(this.$el.querySelector('.js-ht-filter'))
        })

        this.subscribe()
    },

    methods: {
        subscribe() {
            this.$store.subscribe(mutation => {
                if (mutation.type === 'catalog/CATALOG_FILTERING_END') {
                    this.onFilterChange()
                }

                if (mutation.type === 'catalog/filters/CATALOG_FILTERS_DIRTY' && mutation.payload === false) {
                    this.clear()
                }
            })
        },
    }
}
