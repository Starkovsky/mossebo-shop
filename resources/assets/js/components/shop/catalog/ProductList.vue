<template>
    <loading :loading="loading" :no-overlay="true">
        <catalog-product-list
            :products="products"
            :card-type="cardType"
            :loading="loading"
            tile-card-class="col-lg-4 col-xl-3"
        ></catalog-product-list>
    </loading>
</template>

<script>
    import axios from 'axios'

    import Loading from '../../Loading'
    import CatalogProductList from './product-list/CatalogProductList'

    export default {
        name: "ProductList",

        components: {
            CatalogProductList,
            Loading
        },
        data () {
            return {
                error: false,
                loading: true,
                products: [],
            }
        },
        props: {
            url: null,
            limit: {
                type: Number,
                default: 8
            }
        },

        mounted() {
            this.fetchProducts()
        },

        computed: {
            cardType() {
                return this.$root.windowMoreThan('lg') ? 'tile' : 'mobile'
            }
        },

        methods: {
            fetchProducts() {
                // todo: доделать обработку ошибок
                axios.get(this.url)
                    .then(response => {
                        this.products = response.data.products.slice(0, this.limit)
                        this.loading = false
                    })
                    .catch(error => {
                        this.error = true
                        console.log(error);
                    })
                    .finally(() => {
                        // this.loading = false
                    })
            }
        },
    }
</script>

