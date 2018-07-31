<template>
    <div class="catalog-filter block-ui">
        <div v-for="(filter, index) in filters" :key="filter.id" class="catalog-filter-item">
            <template v-if="filter.id === 'prices'">
                <catalog-filter-price
                    :filter="filter"
                    :expanded="true"
                />
            </template>

            <template v-else>
                <catalog-filter
                    :filter="filter"
                    :expanded="index < 4"
                />
            </template>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import CatalogFilter from "./CatalogFilter"
    import CatalogFilterPrice from "./CatalogFilterPrice"

    export default {
        name: "CatalogFilterList",

        components: {
            CatalogFilter,
            CatalogFilterPrice,
        },

        computed: {
            ... mapState({
                filters: state => state.catalog.filters.filters
            })
        }
    }
</script>
