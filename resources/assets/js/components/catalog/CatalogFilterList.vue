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
        methods: {
            FiltersWithOptions: function () {

                var self = this;
                var attributes = [];
                var options = [];
                var i = 0;

                self.attributes.map(function(attribute) {

                    var j = 0;

                    self.options.map(function(option) {

                        if(option.attribute_id == attribute.id) {

                            options[j] = option;

                            j++;
                        }

                    });

                    attributes[i] = {
                        title: attribute.title,
                        options: options
                    };

                    i++;
                });
                return attributes;
            }
        },
        props: [
            'attributes',
            'options'
        ],
        computed: {
            Filters: function () {
                return this.FiltersWithOptions()
            }
        }
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
