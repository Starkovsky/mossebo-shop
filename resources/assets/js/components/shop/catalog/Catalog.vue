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
                    <catalog-filter-list
                        class="block-ui"
                    ></catalog-filter-list>

                    <div v-if="filtersExists" class="catalog-filters-controls">
                        <button @click="clearFilters" type="button" class="button button-light" :disabled="!filtersIsDirty">
                            {{ $root.translate('Reset parameters') }}
                        </button>
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
                        <div class="catalog-top-panel__sort">
                            <multi-select
                                class="multiselect--in-panel"
                                :value="multiselectActiveSortType"
                                :options="multiselectSortOptions"
                                :max-height="300"
                                :placeholder="$root.translate('Sort')"
                                :searchable="false"
                                :hide-selected="false"
                                :multiple="false"
                                :allow-empty="false"
                                @select="setSortTypeByMultiselect"
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
                            <catalog-filter-list></catalog-filter-list>

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
                            <tabs
                                :tabs="sortTypes"
                                :active="activeSortType"
                                @activation="setSortType"
                            ></tabs>
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

    export default {
        name: "Catalog",

        mixins: [
            CatalogMixin
        ],

        props: {
            filterTypes: {
                type: Array,
                default() {
                    return ['prices', 'attributes']
                }
            }
        },
    }
</script>
