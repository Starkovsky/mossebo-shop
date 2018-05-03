<template>
    <div class="product-list">
        <div class="row">
            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-4"
                 v-for="(Product, index) in Products.data"
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
    import GetAllProduct from '../../mixins/GetAllProduct'

    import ProductCard from "./ProductCard";

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
        created() {
            this.GetAllProduct('/api' + window.location.pathname);
        },
        mixins: [
            GetAllProduct
        ]
    }
</script>

<style lang="scss" scoped>

</style>
