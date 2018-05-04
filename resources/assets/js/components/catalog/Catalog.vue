<template>
    <div class="row align-content-stretch">
        <div class="col-md-3">
            <catalog-filter-list></catalog-filter-list>
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
    import GetCatalog from '../../mixins/GetCatalog'

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
                    Filters: {
                        '1': '1'
                    }
                }
            }
        },
        created() {
            this.GetCatalogJSON('/api' + window.location.pathname);
        },
        mixins: [
            GetCatalog
        ]
    }
</script>

<style scoped>

</style>
