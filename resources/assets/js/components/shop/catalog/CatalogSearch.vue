<template>
    <loading :loading="loading">
        <template v-if="error">
            <server-error
                :error="error && !loading"
                @retry="refreshCatalog"
            ></server-error>
        </template>

        <template v-else-if="ready">
            <div class="row align-content-stretch">
                <div class="col-md-3" v-if="$root.windowMoreThan('lg')">
                    <template v-if="filtersExists">
                        <catalog-filter-list
                            class="block-ui"
                        ></catalog-filter-list>

                        <div v-if="filtersExists" class="catalog-filters-controls">
                            <button @click="clearFilters" type="button" class="button button-light" :disabled="!filtersIsDirty">
                                {{ $root.translate('Reset parameters') }}
                            </button>
                        </div>
                    </template>

                    <div class="mt-32">
                        <products-views></products-views>
                    </div>

                    <div class="catalog-filters-banner" v-if="! loading">
                        <banner-column
                            v-if="allProductsQuantity > 12"
                            place="3"
                            quantity="3"
                        ></banner-column>

                        <banner-slider
                            v-else
                            place="3"
                            quantity="3"
                        ></banner-slider>
                    </div>
                </div>

                <div class="col-12" v-else>
                    <div class="catalog-top-panel block-ui">
                        <div class="catalog-top-panel__search">
                            <catalog-sort
                                class="multiselect--in-panel"
                            ></catalog-sort>
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
                            <catalog-filter-list>
                                <catalog-filter-query
                                    :expanded="true"
                                ></catalog-filter-query>
                            </catalog-filter-list>

                            <div v-if="filtersExists" class="catalog-filters-controls">
                                <button @click="clearFilters" type="button" class="button button-light" :disabled="!filtersIsDirty">
                                    Сбросить фильтры
                                </button>
                            </div>
                        </div>
                    </side-popup>
                </div>

                <div class="col-lg-9">
                    <div class="catalog-top-panel block-ui" v-if="$root.windowMoreThan('lg')">
                        <div class="catalog-top-panel__sort">
                            <catalog-sort
                                class="multiselect--in-panel"
                            ></catalog-sort>
                        </div>

                        <div class="catalog-top-panel__card-types">
                            <card-types-changer></card-types-changer>
                        </div>
                    </div>

                    <loading
                        :loading="filtering"
                        :sticky="true"
                        :no-overlay="true"
                    >
                        <template v-if="!filtering">
                            <template v-if="queryIsEmpty">
                                <div>
                                    Пустой запрос
                                </div>
                            </template>

                            <template v-else-if="queryIsShort">
                                <div>
                                    Запрос должен быть не менее трех символов в длину
                                </div>
                            </template>

                            <template v-else-if="products.length > 0">
                                <catalog-product-list
                                    :cardType="activeCardType"
                                    :products="products"
                                    :loading="filtering"
                                    row-class="row--half"
                                    tile-card-class="col-lg-4"
                                ></catalog-product-list>

                                <button-loading
                                    v-if="moreBtnIsVisible"
                                    v-show="!filtering"
                                    class="catalog-more-btn block-ui js-more-btn"
                                    :loading="paginating"
                                    @click="more"
                                >
                                    {{ $root.translate('Show more') }}
                                </button-loading>
                            </template>

                            <template v-else-if="!filtering && nothingFound">
                                <div>
                                    <h4 style="margin-bottom: 30px">
                                        {{ $root.translate('Nothing found') }}
                                    </h4>
                                </div>
                            </template>

                            <template v-else-if="!filtering && products.length === 0">
                                <div>
                                    <h4 style="margin-bottom: 30px">
                                        {{ $root.translate('Nothing found') }}
                                    </h4>

                                    <div style="margin-bottom: 30px">
                                        {{ $root.translate('Try to reset some parameters') }}
                                    </div>

                                    <div>
                                        <button type="button" class="button button-primary" @click="clearFilters">
                                            {{ $root.translate('Reset all parameters') }}
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </template>
                    </loading>
                </div>
            </div>
        </template>
    </loading>
</template>

<script>
    import { mapState } from 'vuex'
    import CatalogMixin from './CatalogMixin'
    import SearchInput from '../../SearchInput'

    export default {
        name: "CatalogSearch",

        mixins: [
            CatalogMixin
        ],

        components: {
            SearchInput
        },

        props: {
            filterTypes: {
                type: Array,
                default() {
                    return ['query', 'categories', 'styles', 'rooms']
                }
            },

            sortTypes: {
                type: Array,
                default() {
                    return ['relevance', 'popular', 'cheaper', 'expensive', 'discount', 'new']
                }
            },
        },

        computed: {
            ... mapState({
                stateQuery: state => state.catalog.search.query,
                nothingFound: state => !state.catalog.products.length
            }),

            queryIsShort() {
                return this.stateQuery.length < 3
            },

            queryIsEmpty() {
                return ! this.stateQuery
            },
        }
    }
</script>
