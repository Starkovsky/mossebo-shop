<template>
    <div class="product-card-mobile block-ui block-ui--with-hover">
        <div class="product-card-mobile__actions text-right">
            <product-actions></product-actions>
        </div>

        <div class="product-card-mobile__image-box">
            <a class="product-card-mobile__link" :href="link">
                <template v-if="product.image">
                    <background-image-loader
                        class="product-card-mobile__image product-image"
                        :screen="true"
                        :image="prepareImage(product.image.src)"
                        :retina-image="prepareImage(product.image.srcset)"
                    ></background-image-loader>
                </template>

                <template v-else>
                    <div class="product-card-mobile__image bg-image product-image"></div>
                </template>
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
