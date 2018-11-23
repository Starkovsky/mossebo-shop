<template>
    <div class="product-card-views">
        <div class="product-card-views__image-box">
            <a class="product-card-views__link" :href="link">
                <template v-if="image">
                    <product-card-image
                        class="product-card-views__image"
                        :image="image"
                        :no-image-loading="noImageLoading"
                    ></product-card-image>
                </template>

                <template v-else>
                    <div class="product-card-views__image image-preview image-preview--1-1"></div>
                </template>
            </a>
        </div>

        <div class="product-card-views__center">
            <div class="product-card-views__name">
                <a class="product-card-views__link" :href="link">
                    {{ product.name }}
                </a>
            </div>

            <div class="product-card-views__rating">
                <rating
                    class-name-modificators="sm"
                    :num="product.rating ? product.rating.num : undefined"
                    :rate="product.rating ? product.rating.rate : undefined"
                ></rating>
            </div>

            <div class="product-card-views__prices">
                <div class="product-card-views__price">
                    <formatted-price
                        :value="product.price"
                    ></formatted-price>
                </div>

                <div v-if="product.old_price" class="product-card-views__old-price">
                    <formatted-price
                        :value="product.old_price"
                    ></formatted-price>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import mixin from './mixin'

    export default {
        name: 'ProductCardViews',

        mixins: [
            mixin
        ],

        computed: {
            image() {
                if (this.product && 'previews' in this.product && this.product.previews.length) {
                    return this.product.previews[0]
                }

                return false
            }
        }
    }
</script>
