<template>
    <div class="product-list">
        <transition-group
            tag="div"
            class="row"
            name="catalog-product" >

            <div class="catalog-product col-6 col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-4"
                 v-for="product in products"
                 :key="product.id" v-show="!product.hide">

                <product-card :product="product" />
            </div>
        </transition-group>
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
    .catalog-product-enter-active {
        transition: opacity .4s;
    }

    .catalog-product-leave-active {
        transition: opacity .2s;
    }

    .catalog-product-enter,
    .catalog-product-leave-to {
        opacity: 0;
    }
</style>
