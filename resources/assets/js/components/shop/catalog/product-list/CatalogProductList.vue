<template>
    <div class="catalog-product-list" v-if="!loading">
        <div :class="{row: true, 'row--half': cardType$ === 'mobile' || cardType$ === 'list', [rowClass]: true}">
            <template v-for="(product, index) in products">
                <catalog-banner
                    :index="index"
                    :key="index + 'banner'"
                ></catalog-banner>

                <div :class="cardClass" :key="product.id">
                    <component
                        :is="cardComponent"
                        :product="product"
                        v-show="show"
                    ></component>
                </div>
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
            },

            cardClass() {
                let className

                switch (this.cardType$) {
                    case 'tile':
                        className = {'catalog-product-list__product': true, [this.tileCardClass]: true}
                        break

                    case 'list':
                        className = {'catalog-product-list__product': true, [this.listCardClass]: true}
                        break

                    case 'mobile':
                        className = {'catalog-product-list__product col-12': true, [this.mobileCardClass]: true}
                        break
                }

                return className
            },

            cardComponent() {
                let componentName

                switch (this.cardType$) {
                    case 'tile':
                        componentName = 'product-card'
                        break

                    case 'list':
                        componentName = 'product-card-long'
                        break

                    case 'mobile':
                        componentName = 'product-card-mobile'
                        break
                }

                return componentName
            }
        }
    }
</script>
