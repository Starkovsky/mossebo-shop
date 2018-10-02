<template>
    <component
        :is="component"
        :product="product"
        :no-image-loading="noImageLoading"
    ></component>
</template>

<script>
    import ProductCard from './types/ProductCard'
    import ProductCardLong from './types/ProductCardLong'
    import ProductCardMobile from './types/ProductCardMobile'
    import ProductCardSale from './types/ProductCardSale'

    const types = {
        default: 'product-card',
        mobile:  'product-card-mobile',
        long:    'product-card-long',
        sale:    'product-card-sale',
    }

    export default {
        name: 'product-card-mother',

        props: [
            'product',
            'no-image-loading',
            'types'
        ],

        components: {
            ProductCard,
            ProductCardLong,
            ProductCardMobile,
            ProductCardSale
        },

        watch: {
            types: 'setTypes'
        },

        data() {
            return {
                types$: null
            }
        },

        created() {
            this.setTypes()
        },

        methods: {
            setTypes() {
                this.types$ = this.types instanceof Array ? this.types : [this.types]
            },

            canUseType(type) {
                return this.types$.indexOf(type) !== -1
            }
        },

        computed: {
            component() {
                if (this.types$.length === 1) {
                    return types[this.types$[0]]
                }

                if (this.canUseType('sale')) {
                    if (this.product.hasSale() && this.product.sale.isActual()) {
                        return types.sale
                    }
                }

                if (this.canUseType('mobile')) {
                    if (this.$root.windowLessThan('lg')) {
                        return types.mobile
                    }
                }

                return types.default
            }
        }
    }
</script>
