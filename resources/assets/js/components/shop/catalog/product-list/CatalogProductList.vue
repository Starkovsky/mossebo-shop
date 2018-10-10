<template>
    <div class="catalog-product-list" v-if="!loading">
        <div :class="{row: true, 'row--half': cardType$ === 'mobile' || cardType$ === 'long', [rowClass]: true}">
            <template v-for="(product, index) in products">
                <catalog-banner
                    :index="index"
                    :key="index + 'banner'"
                ></catalog-banner>

                <div :class="cardClass" :key="product.id">
                    <product-card-mother
                        :product="product"
                        :types="[cardType$, 'sale']"
                        v-show="show"
                    ></product-card-mother>
                </div>
            </template>
        </div>
    </div>
</template>

<script>

    import CatalogBanner from "../banner/CatalogBanner"
    import ProductCardMother from "../product-cards/ProductCardMother"

    export default {
        name: "ProductList",

        components: {
            ProductCardMother,
            CatalogBanner
        },

        props: {
            products: {
                type: Array,
                default: () => []
            },

            cardType: {
                type: String,
                default: () => 'default'
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
        },

        computed: {
            cardType$() {
                if (this.$root.windowMoreThan('lg')) {
                    return this.cardType
                }
                else {
                    return 'mobile'
                }
            },

            cardClass() {
                let className

                switch (this.cardType$) {
                    case 'default':
                        className = {'catalog-product-list__product': true, [this.tileCardClass]: true}
                        break

                    case 'long':
                        className = {'catalog-product-list__product': true, [this.listCardClass]: true}
                        break

                    case 'mobile':
                        className = {'catalog-product-list__product col-12': true, [this.mobileCardClass]: true}
                        break
                }

                return className
            },
        }
    }
</script>
