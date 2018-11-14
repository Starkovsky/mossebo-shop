<template>
    <div class="product-card-mobile block-ui block-ui--with-hover">
        <div class="product-card-mobile__actions text-right">
            <product-actions :product-id="product.id"></product-actions>
        </div>

        <div class="product-card-mobile__image-box">
            <a class="product-card-mobile__link" :href="link">
                <template v-if="image">
                    <product-card-image
                        class="product-card-mobile__image"
                        :image="image"
                        :no-image-loading="noImageLoading"
                    ></product-card-image>
                </template>

                <template v-else>
                    <div class="product-card-mobile__image image-preview image-preview--1-1"></div>
                </template>
            </a>
        </div>

        <div class="product-card-mobile__center">
            <div class="product-card-mobile__name">
                <a class="product-card-mobile__link" :href="link">
                    {{ product.name }}
                </a>
            </div>

            <div v-if="product.badges && product.badges.length" class="product-card-mobile__badges">
                <badges
                    class="badges--small"
                    :badges="product.badges.slice(0, 2)"
                    :no-tooltips="true"
                ></badges>
            </div>

            <div class="product-card-mobile__rating">
                <rating
                    class-name-modificators="sm"
                ></rating>
            </div>

            <div class="product-card-mobile__prices">
                <div class="product-card-mobile__price">
                    <formatted-price
                        :value="product.price"
                    ></formatted-price>
                </div>

                <div v-if="product.old_price" class="product-card-mobile__old-price">
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
        name: "ProductCardMobile",

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
