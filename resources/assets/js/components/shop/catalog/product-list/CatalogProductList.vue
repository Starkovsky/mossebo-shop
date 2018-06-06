<template>
    <div class="catalog-product-list" v-if="!loading">
        <transition-group
            tag="div"
            class="catalog-product-list__row row"
            name="catalog-product" >

            <template v-for="product in products">
                <template v-if="activeCardType === 'tile'">
                    <div
                        class="catalog-product-list__product col-12 col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-4"
                        :key="product.id"
                        v-show="show"
                    >
                        <product-card
                            :product="product"
                        ></product-card>
                    </div>
                </template>

                <template v-if="activeCardType === 'list'">
                    <div class="catalog-product-list__product col-12" :key="product.id">
                        <product-card-long
                            :product="product"
                            v-show="show"
                        ></product-card-long>
                    </div>
                </template>

                <template v-if="activeCardType === 'mobile'">
                    <div class="catalog-product-list__product col-12" :key="product.id">
                        <product-card-mobile
                            :product="product"
                            v-show="show"
                        ></product-card-mobile>
                    </div>
                </template>
            </template>

        </transition-group>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import ProductCard from "../product-cards/ProductCard"
    import ProductCardLong from "../product-cards/ProductCardLong"
    import ProductCardMobile from "../product-cards/ProductCardMobile"

    export default {
        name: "ProductList",

        components: {
            ProductCard,
            ProductCardLong,
            ProductCardMobile
        },

        props: {
            products: {
                type: Array,
                default: () => []
            },
            loading: Boolean,
        },

        data() {
            return {
                show: !this.loading,
                type: 'long'
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
            },

            switchType() {
                if (this.type === 'default') {
                    this.type = 'long'
                }
                else {
                    this.type = 'default'
                }
            }
        },

        computed: {
            ... mapState({
                activeCardType(state) {
                    if (this.$root.windowLessThan('lg')) {
                        return 'mobile'
                    }

                    return state.catalog.cards.active
                }
            })
        },
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
