<template>
    <div class="product-card">
        Product Card
        {{ product.name }}<br>
        {{ product.price }}
    </div>
</template>

<script>
    export default {
        name: "ProductCard",
        props: [
            'product'
        ],
    }
</script>

<style lang="scss" scoped>
    @import "../../sass/variables/colors";
    .product-card {
        width: 100%;
        background: $color-ui;
        padding: 15px;
        margin: 15px 0;
        border-radius: 8px;
        box-shadow: $shadows-primary;
        height: 420px;
        box-sizing: border-box;
    }
</style>
