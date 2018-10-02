<template>
    <div class="product-card-mobile block-ui block-ui--with-hover">
        <div v-if="product.badges" class="product-card-mobile__badges">
            <badges
                :badges="product.badges.slice(0, 1)"
                :no-tooltips="true"
            ></badges>
        </div>

        <div class="product-card-mobile__actions text-right">
            <product-actions></product-actions>
        </div>

        <div class="product-card-mobile__image-box">
            <a class="product-card-mobile__link" :href="link">
                <div v-for="(image, index) in product.previews"
                     v-show="currentImage == index"
                >
                    <product-card-image
                        class="product-card-mobile__image"
                        :image="image"
                        :no-image-loading="noImageLoading"
                    ></product-card-image>
                </div>
            </a>
        </div>

        <div class="product-card-mobile__center">
            <div class="product-card-mobile__name">
                <a class="product-card-mobile__link" :href="link">
                    {{ product.name }}
                </a>
            </div>

            <div class="product-card-mobile__info">
                <div class="product-card-mobile__rating">
                    <rating
                        class-name-modificators="sm"
                    ></rating>
                </div>
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
    }
</script>
