<template>
    <div class="catalog-product-list">
        <div class="catalog-product-list__row row">
            <div class="catalog-product-list__product col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3"
                 v-for="(Product, index) in Products"
                 v-if="index < 8"
                 :key="index"
            >
                <product-card
                    :product="Product"
                >
                </product-card>
            </div>
        </div>
    </div>
</template>

<script>
    import GetProducts from '../../../mixins/GetProducts'

    import ProductCard from "./product-cards/ProductCard"

    export default {
        name: "ProductList",
        components: {
            ProductCard
        },
        data () {
            return {
                Products: [],
            }
        },
        props: [
            'url'
        ],

        mounted() {
            this.GetProductsJSON(this.url)
        },

        mixins: [
            GetProducts
        ]
    }
</script>

<style lang="scss" scoped>

</style>
