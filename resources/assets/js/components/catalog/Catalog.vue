<template>
    <loading class="without-overlay" :loading="loading">
        <template v-if="error">
            <div style="text-align: center;" v-show="!loading">
                <h4 style="margin-bottom: 30px">
                    Произошла ошибка соединения с сервером
                </h4>

                <div>
                    <button @click="refreshCatalog" type="button" class="button button-primary">
                        Попробовать еще раз
                    </button>
                </div>
            </div>
        </template>

        <template v-else>
            <div class="row align-content-stretch">
                <div class="col-md-3">
                    <catalog-filter-list
                        ref="filters"
                        :filters="filters"
                        :prices="prices" />
                </div>

                <div class="col-md-9">
                    <template v-if="productsToShow.length > 0">
                        <catalog-sort :types="sortTypes" :active="activeSortType" @change="setActiveSortType" />

                        <loading class="without-overlay" :loading="productsLoading.inProcess" style="min-height: 450px">
                            <catalog-product-list :products="productsToShow" :loading="productsLoading.inProcess"/>
                        </loading>

                        <div @click="more" class="catalog-more-btn js-more-btn" v-if="moreBtnIsVisible" v-show="!productsLoading.inProcess">
                            Показать еще
                        </div>
                    </template>

                    <template v-else-if="productsToShow.length === 0 && this.products$.length > 0">
                        <div style="text-align: center;">
                            <h4 style="margin-bottom: 30px">
                                В выбранной категории ничего не найдено
                            </h4>

                            <div style="margin-bottom: 30px">
                                Попробуйте сбросить один или несколько фильтров.
                            </div>

                            <div>
                                <button type="button" class="button button-primary" @click="clearFilters">
                                    Сбросить все фильтры
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </loading>
</template>

<script>
    import axios from 'axios'

    import catalogSort from './sort/mixin'
    import catalogFilter from './filter/mixin'
    import catalogProductList from './productList/mixin'

    import Loading from '../Loading'

    export default {
        name: "Catalog",

        components: {
            Loading
        },

        mixins: [
            catalogSort,
            catalogFilter,
            catalogProductList
        ],

        data() {
            return {
                errorRefreshIterations: 0,
                error: false,
                loading: true,
                products$: [],
                productsThatCanBeShown: []
            }
        },

        created() {
            this.fetchCatalog()
        },

        watch: {
            productsThatCanBeShown: 'loadingProductsEnd',
            activeSortType: [
                'loadingProductsStart',
                'changeSortType'
            ],
        },

        methods: {
            fetchProducts() {
                return axios.get('/api' + window.location.pathname)
            },

            fetchFilters() {
                return axios.get('/api/ru/filters')
            },

            fetchCatalog() {
                this.loading = true

                axios.all([this.fetchFilters(), this.fetchProducts()])
                    .then((response) => {
                        this.products$ = response[1].data.products
                        this.filters$ = response[0].data.filters

                        this.init()

                        this.error = false
                        this.loading = false
                    })
                    .catch((error) => {
                        this.loading = false

                        this.$nextTick(() => {
                            this.error = true
                        })

                        console.log(error)
                    })
            },

            // todo: разобраться с этим ужасом
            init() {
                this.$nextTick(() => {
                    this.changeSortType()

                    this.productsThatCanBeShown = this.products$
                    this.applyActiveOptions(this.productsThatCanBeShown)

                    this.bindScrollMoreEvent()
                })

                this.filterChangeHandler = filterName => {
                    this.unbindScrollMoreEvent()
                    this.loadingProductsStart()

                    this.$nextTick(() => {
                        this.resetPage()
                        this.productsThatCanBeShown = this.filterProducts(this.products$)

                        this.applyActiveOptions(this.productsThatCanBeShown, filterName)

                        this.bindScrollMoreEvent()
                    })
                }

                this.$root.$on('filterChanged', this.filterChangeHandler)
            },

            changeSortType() {
                this.loadingProductsStart()

                this.$nextTick(() => {
                    this.products$ = this.sortProducts(this.products$)
                    this.productsThatCanBeShown = this.filterProducts(this.products$)
                })
            },

            /**
             * Попытка загрузки каталога в случае возникновения ошибки.
             */
            refreshCatalog() {
                if (++this.errorRefreshIterations > 1) {
                    window.location.reload()
                }
                else {
                    this.fetchCatalog()
                }
            },
        },

        beforeDestroy() {
            if (this.filterChangeHandler) {
                this.$root.$off('filterChanged', this.filterChangeHandler)
            }

        }
    }
</script>

<style lang="scss" scoped>
    @import "../../../sass/variables/colors";

    .catalog-more-btn {
        margin-top: 17px;
        text-align: center;
        position: relative;
        background: #fff;
        border-radius: 0.25rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .14);
        padding: 24px 32px 23px;
        font-size: 14px / 17px;
        font-weight: 400;
        color: $color-text-primary;
        cursor: pointer;
    }
</style>
