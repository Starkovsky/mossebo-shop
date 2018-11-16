<template>
    <loading :loading="loading">
        <template v-if="error">
            <server-error
                :error="error && !loading"
                @retry="refreshCatalog"
            ></server-error>
        </template>

        <template v-else-if="ready">
            <side-popup ref="popup">
                <div>
                    <catalog-filter-list></catalog-filter-list>

                    <div v-if="filtersExists" class="catalog-filters-controls">
                        <button @click="clearFilters" type="button" class="button button-light" :disabled="!filtersIsDirty">
                            Сбросить фильтры
                        </button>
                    </div>
                </div>
            </side-popup>

            <div class="row align-content-stretch">
                <div class="col-md-3" v-if="$root.windowMoreThan('lg')" style="display: flex; flex-direction: column;">

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

                    <div class="mt-32" style="height: 100%">
                        <fixer
                            v-if="! loading"
                            @fix="showFiltersButton"
                            @unfix="hideFiltersButton"
                            class="mt-32"
                        >
                            <div :class="{'banner-fixer': true, 'banner-fixer--is-active': filtersButtonShowed}">
                                <div class="banner-fixer__button">
                                    <div class="filter-name block-ui" @click="openPopup">
                                    <span class="filter-name__name">
                                        Фильтровать
                                    </span>

                                        <svg class="filter-name__icon">
                                            <use xlink:href="/assets/images/icons.svg#symbol-filters-2"></use>
                                        </svg>
                                    </div>
                                </div>

                                <div class="banner-fixer__banners">
                                    <banner-column
                                        v-if="allProductsQuantity > 12 && false"
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
                        </fixer>
                    </div>
                </div>

                <div class="col-12" v-else>
                    <div class="catalog-top-panel block-ui">
                        <div class="catalog-top-panel__sort">
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
                            <template v-if="products.length > 0">
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
    import CatalogMixin from './CatalogMixin'
    import ProductsViews from '../ProductsViews'

    export default {
        name: "Catalog",

        mixins: [
            CatalogMixin
        ],

        components: {
            ProductsViews
        },

        props: {
            filterTypes: {
                type: Array,
                default() {
                    return ['prices', 'attributes']
                }
            },

            sortTypes: {
                type: Array,
                default() {
                    return ['popular', 'cheaper', 'expensive', 'discount', 'new']
                }
            },
        },

        data() {
            return {
                filtersButtonShowed: false
            }
        },

        methods: {
            showFiltersButton(e) {
                this.filtersButtonShowed = true
            },

            hideFiltersButton(e) {
                if (e) {
                    this.filtersButtonShowed = false
                }
            }
        }
    }
</script>
