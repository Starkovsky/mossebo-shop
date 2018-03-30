<template>
    <div class="product-list">
        <div class="container">
            <div class="row">
                <div class="col-md-3"
                     v-for="Product in Products"
                     :key="Product.id"
                >
                    <product-card
                        :product="Product"
                    >
                    </product-card>
                </div>
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
        data () {
            return {
                Products: {
                    1: {
                        'name': 'Name Product 1',
                        'price': 'Name Product 1',
                    },
                    2: {
                        'name': 'Name Product 2',
                        'price': 'Name Product 2',
                    },
                    3: {
                        'name': 'Name Product 3',
                        'price': 'Name Product 3',
                    },
                    4: {
                        'name': 'Name Product 4',
                        'price': 'Name Product 4',
                    },
                    5: {
                        'name': 'Name Product 5',
                        'price': 'Name Product 5',
                    },
                }
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
