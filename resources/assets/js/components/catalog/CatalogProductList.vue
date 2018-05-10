<template>
    <div class="product-list">
        <div class="row">
            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-4"
                 v-for="(Product, index) in products"
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

    import ProductCard from "./ProductCard";

    export default {
        name: "ProductList",
        components: {
            ProductCard
        },
        props: [
            'products'
        ]
    }
</script>

<style lang="scss" scoped>

</style>
