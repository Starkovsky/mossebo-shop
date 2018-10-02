<template>
    <div :class="{
        'product-card-sale block-ui block-ui--with-hover': true,
        'product-card-sale--small': isSmall
    }">

        <div class="product-card-sale__actions text-right">
            <product-actions></product-actions>
        </div>

        <div v-if="isSmall" class="product-card-sale__timer">
            <div class="action-small-timer">
                <div class="action-small-timer__label">
                    Акция действует
                </div>

                <div class="action-small-timer__timer">
                    <timer
                        :time="saleTime"
                    ></timer>
                </div>
            </div>
        </div>

        <div v-if="!isSmall && product.images && product.images.length > 0" class="product-card-sale__thumbs">
            <div class="product-thumbs">
                <div class="product-thumbs__container">
                    <template v-for="image in images">
                        <div :key="image.id" class="product-thumbs__item">
                            <div @click="setImage(image.id)" class="product-thumbs__btn">
                                <background-image-loader
                                    class="product-thumbs__image"
                                    :image="prepareImage(image.thumb.src)"
                                    :retina-image="prepareImage(image.thumb.srcset)"
                                ></background-image-loader>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <a class="product-card-sale__link"
           :href="link"
        >
            <div class="product-card-sale__image-box">
                <background-image-loader
                    v-if="image"
                    :key="image.id"
                    class="product-card-sale__image"
                    :screen="true"
                    :image="prepareImage(image.small.src)"
                    :retina-image="prepareImage(image.small.srcset)"
                    :reset="true"
                ></background-image-loader>

                <div v-else class="product-card-sale__image"></div>
            </div>

            <div class="product-card-sale__name">
                {{ product.name }}
            </div>
        </a>

        <div class="product-card-sale__reviews">
            <rating></rating>
        </div>

        <div class="product-card-sale__prices">
            <div class="product-card-sale__price">
                <formatted-price
                    :value="product.price"
                ></formatted-price>
            </div>

            <div class="product-card-sale__old-price">
                <formatted-price
                    :value="product.old_price"
                ></formatted-price>
            </div>

            <div v-if="!isSmall" class="product-card-sale__timer">
                <div class="action-small-timer">
                    <div class="action-small-timer__label">
                        Акция действует
                    </div>

                    <div class="action-small-timer__timer">
                        <timer
                            :time="saleTime"
                        ></timer>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import mixin from './types/mixin'
    import Timer from '../../../Timer'
    import ProductImagesHat from '../../../../mixins/ProductImagesHat'
    import BackgroundImageLoader from '../../../imageLoaders/BackgroundImageLoader'

    export default {
        name: "ProductCardSale",

        mixins: [
            mixin,
            ProductImagesHat
        ],

        components: {
            Timer,
            BackgroundImageLoader
        },

        props: {
            small: {
                type: Boolean,
                default: false,
            }
        },

        data() {
            return {
                image: false,
                linkIsHovered: false
            }
        },

        mounted() {
            if (this.images.length) {
                this.image = this.images[0]
            }
        },

        methods: {
            setImage(id) {
                this.image = this.product.images.find(image => image.id === id)
            },
        },

        computed: {
            images() {
                if (! (this.product && this.product.images && this.product.images.length)) return []

                return this.product.images.slice(0, 3)
            },

            isSmall() {
                return this.small || this.$root.isMobile
            },
        }
    }
</script>
