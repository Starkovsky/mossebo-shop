import CatalogFilterList from './CatalogFilterList'

export default {
    components: {
        CatalogFilterList
    },

    data() {
        return {
            filters$: [],
            filtersIsDirty: false
        }
    },

    methods: {
        checkProduct(product) {
            let filters = this.getFilterComponents()
            let group = false
            let flag = true

            for (let i = 0; i < filters.length; i++) {
                let filter = filters[i]

                if (! filter.checkProduct(product)) {
                    if (flag) {
                        flag = false
                        group = filter
                    }
                    else {
                        group = false
                        break
                    }
                }
            }

            if (group) {
                group.prepareActiveOptions(product)
            }

            return flag
        },

        filterProducts(products) {
            if (this.filters.length === 0) {
                return [
                    ... products
                ]
            }
            else {
                return products.filter(product => this.checkProduct(product))
            }
        },

        applyActiveOptions() {
            this.$nextTick(() => {
                if (this.productsThatCanBeShown.length === 0) return

                this.getFilterComponents().forEach(filterComponent => {
                    this.productsThatCanBeShown.forEach(product => {
                        filterComponent.prepareActiveOptions(product)
                    })

                    if (filterComponent.isDirty()) {
                        this.filtersIsDirty = true
                    }

                    filterComponent.applyActiveOptions(this.lastFilterName)
                    this.lastFilterName = false
                })
            })
        },

        getFilterComponents() {
            return this.$refs.filters ? this.$refs.filters.getFiltersArray() : []
        },

        clearFilters() {
            if (! this.filtersIsDirty) return

            this.getFilterComponents().forEach(component => {
                component.clear()
            })

            this.filtersIsDirty = false

            this.$root.$emit('filterChanged')
        }
    },

    computed: {
        prices() {
            if (this.products$.length === 0) {
                return false
            }

            return this.products$.reduce((acc, product) => {
                if (product.price < acc[0]) {
                    acc[0] = product.price
                }

                if (product.price > acc[1]) {
                    acc[1] = product.price
                }

                return acc
            }, [this.products$[0].price, this.products$[0].price])
        },

        allPresentedOptions() {
            return this.products$.reduce((acc, product) => {
                (product.options || []).forEach(optionId => {
                    if (acc.indexOf(optionId) === -1) {
                        acc.push(optionId)
                    }
                })

                return acc
            }, [])
        },

        filters() {
            let filters = this.filters$.reduce((acc, filter) => {
                let options = (filter.options || []).reduce((acc, option) => {
                    if (this.allPresentedOptions.indexOf(option.id) !== -1) {
                        acc.push(option)
                    }

                    return acc
                }, [])

                if (options.length > 1) {
                    acc.push({
                        ... filter,
                        options: _.orderBy(options, 'position')
                    })
                }

                return acc
            }, [])

            return _.orderBy(filters, 'position')
        },
    }
}
