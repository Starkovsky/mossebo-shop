<template>
    <div class="catalog-product-list" v-if="!loading">
        <transition-group
            tag="div"
            class="row"
            name="catalog-product" >

            <template v-for="product in products">
                <div class="catalog-product col-6 col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-4"
                     :key="product.id"
                     v-show="show" >

                    <product-card :product="product" />
                </div>
            </template>

        </transition-group>
    </div>
</template>

<script>
    import ProductCard from "../ProductCard"

    export default {
        name: "ProductList",

        components: {
            ProductCard,
        },

        props: {
            products: {
                type: Array,
                default: () => []
            },
            loading: Boolean
        },

        data() {
            return {
                show: !this.loading
            }
        },

        watch: {
            loading: 'onLoadingChange'
        },

        methods: {
            onLoadingChange() {
                this.$nextTick(() => {
                    this.show = !this.loading
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .catalog-product-enter-active {
        transition: opacity .4s;
    }

    .catalog-product-enter,
    .catalog-product-leave-to {
        opacity: 0;
    }
</style>
