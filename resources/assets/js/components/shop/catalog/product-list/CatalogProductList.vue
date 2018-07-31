<template>
    <div class="catalog-product-list" v-if="!loading">
        <div :class="{row: true, 'row--half': cardType$ === 'mobile' || cardType$ === 'list', [rowClass]: true}">
            <template v-for="(product, index) in products">
                <catalog-banner
                    :index="index"
                    :key="index + 'banner'"
                ></catalog-banner>

                <template v-if="cardType$ === 'tile'">
                    <div
                        :class="{'catalog-product-list__product': true, [tileCardClass]: true}"
                        :key="product.id"
                        v-show="show"
                    >
                        <product-card
                            :product="product"
                        ></product-card>
                    </div>
                </template>

                <template v-if="cardType$ === 'list'">
                    <div :class="{'catalog-product-list__product': true, [listCardClass]: true}" :key="product.id">
                        <product-card-long
                            :product="product"
                            v-show="show"
                        ></product-card-long>
                    </div>
                </template>

                <template v-if="cardType$ === 'mobile'">
                    <div :class="{'catalog-product-list__product col-12': true, [mobileCardClass]: true}" :key="product.id">
                        <product-card-mobile
                            :product="product"
                            v-show="show"
                        ></product-card-mobile>
                    </div>
                </template>
            </template>
        </div>
    </div>
</template>

<script>

    import CatalogBanner from "../banner/CatalogBanner"
    import ProductCard from "../product-cards/ProductCard"
    import ProductCardLong from "../product-cards/ProductCardLong"
    import ProductCardMobile from "../product-cards/ProductCardMobile"

    export default {
        name: "ProductList",

        components: {
            ProductCard,
            ProductCardLong,
            ProductCardMobile,
            CatalogBanner
        },

        props: {
            products: {
                type: Array,
                default: () => []
            },

            cardType: {
                type: String,
                default: () => 'tile'
            },

            noMobileCard: {
                type: Boolean,
                default: false
            },

            loading: Boolean,

            rowClass: {
                default: ''
            },

            tileCardClass: {
                default : 'col-lg-3'
            },

            listCardClass: {
                default: 'col-12'
            },

            mobileCardClass: {
                default: 'col-12'
            }
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
            cardType$() {
                if (this.$root.windowMoreThan('lg')) {
                    return this.cardType
                }
                else {
                    return 'mobile'
                }
            }
        }
    }
</script>
