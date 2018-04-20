<template>
    <div class="product-list">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3"
                 v-for="(Product, index) in Products"
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
        mounted() {
            this.GetAllProduct();
        },
        mixins: [
            GetAllProduct
        ]
    }
</script>

<style lang="scss" scoped>

</style>
