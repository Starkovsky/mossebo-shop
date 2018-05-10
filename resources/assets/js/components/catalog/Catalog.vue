<template>
    <div class="row align-content-stretch">
        <div class="col-md-3">
            <catalog-filter-list
                :attributes="Attributes"
                :options="Options"
            >
            </catalog-filter-list>
        </div>
        <div class="col-md-9">
            <div class="catalog-list-property">
                Сортировка
            </div>
            <catalog-product-list :products="Products"></catalog-product-list>
        </div>
    </div>
</template>

<script>

    import axios from 'axios'

    import CatalogFilterList from './CatalogFilterList'
    import CatalogProductList from './CatalogProductList'

    export default {
        name: "Catalog",
        components: {
            'catalog-filter-list': CatalogFilterList,
            'catalog-product-list': CatalogProductList,
        },
        data() {
            return {
                Products: []
            }
        },
        created() {
            this.GetCatalogJSON('/api' + window.location.pathname);
        },
        methods: {
            GetCatalogJSON($url) {
                var self = this;
                axios.get($url)
                    .then(function (response) {
                        self.$data.Products = response.data.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            uniq_fast(a) {
                var seen = {};
                var out = [];
                var len = a.length;
                var j = 0;
                for(var i = 0; i < len; i++) {
                    var item = a[i];
                    if(seen[item.id] !== 1) {
                        seen[item.id] = 1;
                        out[j++] = item;
                    }
                }
                return out;
            },
            attributesScope() {
                var self = this;
                var attributes_tmp = [];
                var i = 0;
                self.Products.map(function(product) {

                    product.attributes.map(function(attribute) {

                        attributes_tmp[i] = {
                                id: attribute.id,
                                title: attribute.i18n.title
                            };

                        i++;
                    });
                });
                return this.uniq_fast(attributes_tmp);
            },
            optionsScope() {
                var self = this;
                var options_tmp = [];
                var i = 0;
                self.Products.map(function(product) {

                    product.attributes_options.map(function(options) {

                        options_tmp[i] = {
                                id: options.id,
                                attribute_id: options.attribute_id,
                                position: options.position,
                                value: options.i18n.value
                            };

                        i++;
                    });
                });
                return this.uniq_fast(options_tmp);
            }
        },
        computed: {
            Attributes: function () {
                return this.attributesScope()
            },
            Options: function () {
                return this.optionsScope()
            }
        }
    }
</script>

<style scoped>

</style>
