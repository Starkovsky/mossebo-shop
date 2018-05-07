<template>
    <div class="row align-content-stretch">
        <div class="col-md-3">
            <catalog-filter-list :filters="Catalog.Filters"></catalog-filter-list>
        </div>
        <div class="col-md-9">
            <div class="catalog-list-property">
                Сортировка
            </div>
            <catalog-product-list :products="Catalog.Products"></catalog-product-list>
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
        data () {
            return {
                Catalog: {
                    Products: [],
                    Filters: []
                }
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
                        self.$data.Catalog = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },
        computed: {

        }
    }
</script>

<style scoped>

</style>
