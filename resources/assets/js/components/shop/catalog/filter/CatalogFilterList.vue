<template>
    <div class="catalog-filter block-ui">
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

    @import "../../../../../sass/variables/colors";
    @import "../../../../../sass/variables/variables";

    .catalog {
        &-filter {
            &-item {
                font-size: 14px;
                font-weight: 400;
                color: $color-text-secondary;

                & + & {
                    border-top: 1px solid $color-border;
                }
            }
        }
    }
</style>
