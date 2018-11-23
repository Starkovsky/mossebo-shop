<template>
    <div class="product-card block-ui block-ui--with-hover">
        <div v-if="product.badges && product.badges.length" class="product-card__badges">
            <badges
                :badges="product.badges.slice(0,2)"
            ></badges>
        </div>

        <div class="product-card__actions text-right">
            <product-actions :product-id="product.id"></product-actions>
        </div>

        <a class="product-card__link"
           :href="link"
        >
            <div class="product-card__image-box">
                <template v-if="product.previews && product.previews.length">
                    <div
                        class="product-thumbs-slider"
                        v-if="product.previews.length > 1"
                        @mouseleave="showImage(0)"
                    >
                        <div
                            class="product-thumbs-slider__item"
                            @mouseover="showImage(index)"
                            v-for="(image, index) in product.previews"
                        ></div>
                    </div>

                    <template v-for="(image, index) in product.previews">
                        <product-card-image
                            :key="image.id"
                            v-show="currentImage === index"
                            class="product-card__image"
                            :image="image"
                            :no-image-loading="noImageLoading"
                        ></product-card-image>
                    </template>
                </template>

                <template v-else>
                    <div class="product-card__image image-preview image-preview--1-1"></div>
                </template>
            </div>

            <div class="product-card__name">
                {{ product.name }}
            </div>
        </a>

        <div class="product-card__info">
            <div class="product-card__reviews">
                <rating
                    :num="product.rating ? product.rating.num : undefined"
                    :rate="product.rating ? product.rating.rate : undefined"
                ></rating>
            </div>

            <div class="product-card__price">
                <formatted-price
                    :value="product.price"
                ></formatted-price>
            </div>

            <div class="product-card__old-price">
                <formatted-price
                    :value="product.old_price"
                ></formatted-price>
            </div>

            <div class="product-card__buttons">
                <product-card-button
                    :link="link"
                    :status="inCart ? 'in-cart' : 'not-in-cart'"
                    @side-click="addToCart"
                ></product-card-button>
            </div>
        </div>
    </div>
</template>

<script>
    import mixin from './mixin'

    export default {
        name: "ProductCard",

        mixins: [
            mixin
        ],
    }
</script>
