<template>
    <product-card-mobile
        v-if="type === 'mobile'"
        :product="product$"
        :no-image-loading="noImageLoading"
        class="product-card-mobile--promo"
    ></product-card-mobile>

    <product-card-long
        v-else-if="type === 'long'"
        :product="product$"
        :no-image-loading="noImageLoading"
        class="product-card-long--promo"
    ></product-card-long>

    <product-card
        v-else
        :product="product$"
        :no-image-loading="noImageLoading"
        class="product-card--promo"
    ></product-card>
</template>

<script>
    import ProductCard from './ProductCard'
    import ProductCardLong from './ProductCardLong'
    import ProductCardMobile from './ProductCardMobile'
    import ProductSaleExtendedMixin from '../../../../../mixins/ProductSaleExtended'

    export default {
        name: "ProductCardSale",

        mixins: [
            ProductSaleExtendedMixin
        ],

        components: {
            ProductCard,
            ProductCardLong,
            ProductCardMobile
        },

        props: {
            type: null,
            noImageLoading: null,
        },

        watch: {
            'product.sale.timeLeft': function(value) {
                if (value <= 0) {
                    this.$emit('sale-time-end')
                }
            }
        },

        methods: {
            setImage(id) {
                this.image = this.previews.find(image => image.id === id)
            },

            checkSize() {
                if (this.$el.clientWidth > 485) {
                    if (this.isSmall) {
                        this.isSmall = false
                    }
                }
                else {
                    if (! this.isSmall) {
                        this.isSmall = true
                    }
                }
            },
        },

        computed: {
            previews() {
                if (! (this.product && this.product.previews && this.product.previews.length)) return false

                return this.product.previews.slice(0, 3)
            },

            product$() {
                return {
                    ... this.product,
                    price: this.minPrice,
                    old_price: this.maxPrice,
                    previews: this.previews,
                    badges: this.badges
                }
            }
        }
    }
</script>
