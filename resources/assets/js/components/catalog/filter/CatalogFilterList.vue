<template>
    <div class="catalog-filter">
        <div class="catalog-filter-item" v-if="prices">
            <catalog-filter-price
                ref="filter-price"
                name="price"
                :prices="prices" />
        </div>

        <div v-for="(filter, index) in filters" :key="filter.id" class="catalog-filter-item">
            <catalog-filter
                :ref="'filter-' + filter.id"
                :id="filter.id"
                :title="filter.title"
                :options="filter.options"
                :expanded="index < 4" />
        </div>

        <div v-if="filters.length > 0" class="catalog-filters-controls">
            <button @click="clear" type="button" class="button button-primary">
                Сбросить фильтры
            </button>
        </div>
    </div>
</template>

<script>
    import CatalogFilter from "./CatalogFilter";
    import CatalogFilterPrice from "./CatalogFilterPrice";

    export default {
        name: "CatalogFilterList",

        components: {
            CatalogFilter,
            CatalogFilterPrice
        },

        props: [
            'prices',
            'filters'
        ],

        methods: {
            clear() {
                this.filtersArray.forEach(filterComponent => filterComponent.clear())
                this.$root.$emit('filterChanged')
            },
        },

        computed: {
            filtersArray() {
                let filters = []

                for (let key in this.$refs) {
                    if (this.$refs[key] instanceof Array) {
                        this.$refs[key].forEach(component => {
                            filters.push(component)
                        })
                    }
                    else {
                        filters.push(this.$refs[key])
                    }
                }

                return filters
            },
        }
    }
</script>

<style lang="scss" scoped>

    @import "../../../../sass/variables/colors";
    @import "../../../../sass/variables/variables";

    .catalog {
        &-filter {
            &-item {
                background: $color-ui;
                font-size: 14px;
                font-weight: 400;
                color: $color-text-secondary;
                box-shadow: $shadows-primary;
                & + & {
                    border-top: 1px solid $color-border;
                }

                &:first-child {
                    border-top-left-radius: 5px;
                    border-top-right-radius: 5px;
                }

                &:last-child {
                    border-bottom-left-radius: 5px;
                    border-bottom-right-radius: 5px;
                }
            }
        }

        &-filters-controls {
            text-align: center;
            margin-top: 30px;
        }
    }
</style>
