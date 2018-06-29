<template>
    <loading :loading="loading">
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
                <div class="col-md-3" v-if="$root.windowMoreThan('lg')">
                    <catalog-filter-list
                        ref="filters"
                        :filters="filters"
                        :prices="prices"
                    ></catalog-filter-list>

                    <div v-if="filters.length > 0" class="catalog-filters-controls">
                        <button @click="clearFilters" type="button" class="button button-light" :disabled="!filtersIsDirty">
                            Сбросить фильтры
                        </button>
                    </div>

                    <div class="catalog-filters-banner" v-if="! loading">
                        <banner-random></banner-random>
                    </div>
                </div>

                <div class="col-12" v-else>
                    <div class="catalog-top-panel block-ui">
                        <div class="catalog-top-panel__sort">
                            <multi-select
                                class="multiselect--mobile-sort"
                                :value="multiselectActiveSortType"
                                :options="multiselectSortOptions"
                                :max-height="300"
                                :placeholder="$root.translate('Sort')"
                                :searchable="false"
                                :hide-selected="false"
                                :multiple="false"
                                :allow-empty="false"
                                @select="setActiveSortTypeByMultiselect"
                            >
                                <template slot="option" slot-scope="props">
                                    {{ props.option.title }}
                                </template>

                                <template slot="singleLabel" slot-scope="props">
                                    {{ props.option.title }}
                                </template>
                            </multi-select>
                        </div>

                        <div class="catalog-top-panel__filter-btn">
                            <div class="filters-mobile-btn" @click="openPopup">
                                <svg class="filters-mobile-btn__icon">
                                    <use xlink:href="/assets/images/icons.svg#symbol-filters"></use>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <side-popup ref="popup">
                        <div>
                            <catalog-filter-list
                                ref="filters"
                                :filters="filters"
                                :prices="prices"
                            ></catalog-filter-list>

                            <div v-if="filters.length > 0" class="catalog-filters-controls">
                                <button @click="clearFilters" type="button" class="button button-light" :disabled="!filtersIsDirty">
                                    Сбросить фильтры
                                </button>
                            </div>
                        </div>
                    </side-popup>
                </div>

                <div class="col-lg-9">
                    <template v-if="productsToShow.length > 0">
                        <div class="catalog-top-panel block-ui" v-if="$root.windowMoreThan('lg')">
                            <div class="catalog-top-panel__sort">
                                <tabs
                                    :tabs="sortTypes"
                                    :active="activeSortType"
                                    @activation="setActiveSortType"
                                ></tabs>
                            </div>

                            <div class="catalog-top-panel__card-types">
                                <card-types-changer></card-types-changer>
                            </div>
                        </div>


                        <loading
                            :loading="productsLoading.inProcess"
                            :sticky="true"
                            :no-overlay="true"
                        >
                            <catalog-product-list
                                :cardType="activeCardType"
                                :products="productsToShow"
                                :loading="productsLoading.inProcess"
                                row-class="row--half"
                                tile-card-class="col-lg-4"
                            ></catalog-product-list>
                        </loading>

                        <button-loading
                            v-if="moreBtnIsVisible"
                            v-show="!productsLoading.inProcess"
                            class="catalog-more-btn block-ui js-more-btn"
                            :loading="productsToShowCalculateInProcess"
                        >
                            Показать еще
                        </button-loading>
                    </template>

                    <template v-else-if="!productsToShowCalculateInProcess && productsToShow.length === 0 && this.products$.length > 0">
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
    import catalogProductList from './product-list/mixin'

    import Loading from '../../Loading'
    import Tabs from '../../Tabs'
    import CardTypesChanger from './CardTypesChanger'
    import ButtonLoading from '../../buttons/ButtonLoading'
    import PendingLoader from '../../../scripts/PendingLoader'
    import BannerRandom from '../../banners/BannerRandom'
    import SidePopup from '../../SidePopup'
    import MultiSelect from 'vue-multiselect'


    import DataHandler from '../../../scripts/DataHandler'

    export default {
        name: "Catalog",

        components: {
            Loading,
            Tabs,
            CardTypesChanger,
            ButtonLoading,
            BannerRandom,
            SidePopup,
            MultiSelect
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
                productsThatCanBeShown: [],
                productsToShow: [],
                activeCardType: '',
                productsToShowCalculateInProcess: false,
                productsLoading: {
                    inProcess: false,
                    minTime: 700,
                    handler: false
                },

                lastFilterName: false
            }
        },

        watch: {
            productsToShow: 'loadingProductsEnd',
            perPage: 'calculateProductsToShow',
            productsThatCanBeShown: [
                'calculateProductsToShow',
                'applyActiveOptions'
            ],
            activeCardType: 'calculateProductsToShow',
            activeSortType: [
                'loadingProductsStart',
                'changeSortType'
            ],
        },

        created() {
            let throttle = _.throttle(() => {
                this.productsToShowCalculateInProcess = false
                this.unbindScrollMoreEvent()
                this.calculatePerPager()

                this.loadingProductsEnd()
                this.bindScrollMoreEvent()
            }, 300)

            this.calculateProductsToShowThrottler = () => {
                this.productsToShowCalculateInProcess = true

                throttle()
            }

            this.$store.subscribe(mutation => {
                if (mutation.type === 'catalog/CATALOG_SET_CARD_TYPE') {
                    this.setActiveCardType()
                }
            })

            this.filterChangeHandler = filterName => {
                this.lastFilterName = filterName
                this.productsThatCanBeShown = this.filterProducts(this.products$)
                this.resetPage()
            }

            this.$store.dispatch('catalog/init')

            this.fetchCatalog()
        },

        methods: {
            fetchProducts() {
                return axios.get('/api' + window.location.pathname)
            },

            fetchFilters() {
                return DataHandler.get('attributes')
            },

            fetchCatalog() {
                this.loading = true

                Promise.all([this.fetchFilters(), this.fetchProducts()])
                    .then((response) => {
                        this.products$ = response[1].data.products
                        this.filters$ = response[0].attributes

                        this.init()

                        this.error = false
                    })
                    .catch((error) => {
                        this.error = true

                        console.error(error)
                    })
                    .finally (() => {
                        this.loading = false
                    })
            },

            // todo: разобраться с этим ужасом
            init() {
                this.$root.$on('filterChanged', this.filterChangeHandler)
                this.$root.$on('resize', this.setActiveCardType)

                this.loadingProductsStart()
                this.setActiveCardType()
                this.changeSortType()
            },

            changeSortType() {
                this.products$ = this.sortProducts(this.products$)
                this.productsThatCanBeShown = this.filterProducts(this.products$)
                this.resetPage()
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

            calculateProductsToShow() {
                this.loadingProductsStart()

                this.calculateProductsToShowThrottler()
            },

            setActiveCardType() {
                let type = this.$root.windowLessThan('lg') ? 'mobile' : this.$store.state.catalog.cards.active

                if (type !== this.activeCardType) {
                    this.resetPage()
                    this.activeCardType = type
                }
            },

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

            resetPage() {
                this.page = 1

                this.calculateProductsToShow()
            },

            calculatePerPager() {
                let end = Math.min(this.perPage * this.page, this.productsThatCanBeShown.length)

                this.productsToShow = this.productsThatCanBeShown.slice(0, end)
            },

            openPopup() {
                this.$refs.popup.open()
            },

            setActiveSortTypeByMultiselect(type) {
                this.setActiveSortType(type.value)
            }
        },

        computed: {
            multiselectSortOptions() {
                return Object.keys(this.sortTypes).reduce((acc, key) => {
                    acc.push({
                        title: this.sortTypes[key],
                        value: key
                    })

                    return acc
                }, [])
            },

            multiselectActiveSortType() {
                return this.multiselectSortOptions.find(option => option.value === this.activeSortType)
            }
        },

        beforeDestroy() {
            if (this.filterChangeHandler) {
                this.$root.$off('filterChanged', this.filterChangeHandler)
            }
        }
    }
</script>
