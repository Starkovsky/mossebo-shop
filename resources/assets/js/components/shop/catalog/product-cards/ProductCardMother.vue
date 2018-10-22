<template>
    <product-card-sale-mother
        v-if="type$ === 'sale'"
        :product="product"
        :no-image-loading="noImageLoading"
        :type="baseType"
        @sale-time-end="setType"
    ></product-card-sale-mother>

    <component
        v-else
        :is="component"
        :product="product"
        :no-image-loading="noImageLoading"
    ></component>
</template>

<script>
    import ProductCard from './types/ProductCard'
    import ProductCardLong from './types/ProductCardLong'
    import ProductCardMobile from './types/ProductCardMobile'
    import ProductCardSaleMother from './types/ProductCardSaleMother'

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
            ProductCardSaleMother
        },

        watch: {
            types: 'setTypes'
        },

        data() {
            return {
                types$: null,
                type$: null
            }
        },

        created() {
            this.setTypes()
        },

        methods: {
            setTypes() {
                this.types$ = this.types instanceof Array ? this.types : [this.types]
                this.setType()
            },

            getType() {
                if (this.types$.length === 1) {
                    return this.types$[0]
                }

                if (this.canUseType('sale')) {
                    if (this.product.hasSale() && this.product.sale.isActual()) {
                        return 'sale'
                    }
                }

                return this.baseType
            },

            setType() {
                this.type$ = this.getType()
            },

            canUseType(type) {
                return this.types$.indexOf(type) !== -1
            }
        },

        computed: {
            baseType() {
                if (this.canUseType('mobile')) {
                    if (this.$root.windowLessThan('lg')) {
                        return 'mobile'
                    }
                }

                let types = this.types$.filter(type => type !== 'sale')

                return types.length ? types[0] : 'default'
            },

            component() {
                return types[this.type$]
            }
        }
    }
</script>
