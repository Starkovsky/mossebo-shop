<template>
    <div class="row align-content-stretch">
        <div class="col-md-3">
            <catalog-filter-list
                ref="filters"
                :filters="filters" />
        </div>

        <div class="col-md-9">
            <div class="catalog-list-property">
                Сортировка
            </div>

            <catalog-product-list :products="filteredProducts" />
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    import CatalogFilterList from './CatalogFilterList'
    import CatalogProductList from './CatalogProductList'

    export default {
        name: "Catalog",

        components: {
            CatalogFilterList,
            CatalogProductList,
        },

        data() {
            return {
                products$: [],
                filters$: [],
                filteredProducts: []
            }
        },

        watch:{
            'filters': 'filterProducts'
        },

        created() {
            this.fetchCatalog()
        },

        mounted() {
            this.$root.$on('filterChange', () => this.filterProducts())
        },

        methods: {
            fetchProducts() {
                return axios.get('/api' + window.location.pathname)
            },

            fetchFilters() {
                return axios.get('/api/ru/filters')
            },

            fetchCatalog() {
                axios.all([this.fetchFilters(), this.fetchProducts()])
                    .then((response) => {
                        this.filters$ = response[0].data.filters
                        this.products$ = response[1].data.products
                    })
                    .catch((error) => {
                        // todo: поставить заглушку в случае ошибки
                        // кнопка повторной попытки загрузки
                        console.log(error)
                    })
            },

            getUniqueItems(arr) {
                let existingIds = {}

                return arr.filter(item => {
                    if (item.id in existingIds) {
                        return false
                    }

                    existingIds[item.id] = 1

                    return true
                })
            },

            attributesScope() {
                let attributes = this.products.reduce((acc, product) => {
                    product.attributes.forEach(attribute => {
                        acc.push({
                            id: attribute.id,
                            title: attribute.i18n.title
                        })
                    })

                    return acc
                }, [])

                return this.getUniqueItems(attributes)
            },

            optionsScope() {
                let options = this.products.reduce((acc, product) => {
                    product.attributes_options.forEach(option => {
                        acc.push({
                            id: option.id,
                            attribute_id: option.attribute_id,
                            position: option.position,
                            value: option.i18n.value
                        })
                    })

                    return acc
                }, [])

                return this.getUniqueItems(options)
            },

            filterProducts() {
                this.filteredProducts = []

                this.$nextTick(() => {
                    if (this.filters.length === 0) {
                        this.filteredProducts = this.products$
                    }
                    else {
                        this.filteredProducts = this.products$.filter(product => this.$refs.filters.check(product))
                    }
                })
            },

        },

        computed: {
            attributes() {
                return this.attributesScope()
            },

            options() {
                return this.optionsScope()
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
</script>
