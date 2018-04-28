<template>
    <div class="catalog-filter">
        <div class="catalog-filter-item">
            <catalog-filter-price></catalog-filter-price>
        </div>
        <div class="catalog-filter-item"
             v-for="(Filter, index) in Filters"
             :key="index"
        >
            <catalog-filter
                :filterID="index"
                :filter="Filter"
            >
            </catalog-filter>
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
        data () {
            return {
                Filters: [
                    {
                        name: 'Стили',
                        values: ['Лофт','Современный','Класический','Фьюжн','Скандинавский','Неоклассика']
                    },
                    {
                        name: 'Бренд',
                        values: ['Бренд 1','Бренд 2','Бренд 3','Бренд 4','Бренд 5','Бренд 6']
                    },
                    {
                        name: 'Страна производства',
                        values: ['Россия','Украина','США','Франция','Испания','Канада']
                    }
                ],
            }
        },
    }
</script>

<style lang="scss" scoped>

    @import "../../../sass/variables/colors";
    @import "../../../sass/variables/variables";

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
    }


</style>
