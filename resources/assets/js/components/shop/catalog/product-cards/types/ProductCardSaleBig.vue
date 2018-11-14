<template>
    <product-card-sale-mother
        v-if="isSmall"
        :product="product"
        :no-image-loading="noImageLoading"
    ></product-card-sale-mother>

    <div v-else class="product-card-promo">
        <div class="product-card-promo__left">
            <div class="product-card-promo__badges">
                <div class="row row--half align-items-center">
                    <div class="col-auto">
                        <badge
                            color="#FF1B51"
                            :text="discountPercent"
                        ></badge>
                    </div>

                    <div class="col-auto">
                        Акция
                    </div>
                </div>
            </div>

            <div class="product-card-promo__timer">
                <div class="action-small-timer">
                    <div class="action-small-timer__label">
                        До конца акции:
                    </div>

                    <div class="action-small-timer__timer">
                        <timer
                            :time="product.sale.timeLeft"
                            :class-name-modificators="timerSize"
                        ></timer>
                    </div>
                </div>
            </div>

            <div class="product-card-promo__info">
                <a class="product-card-promo__link"
                   :href="link"
                   @mouseover="hover"
                   @mouseleave="unHover"
                >
                    <div class="product-card-promo__name">
                        {{ product.name }}
                    </div>
                </a>

                <div class="product-card-promo__reviews">
                    <rating></rating>
                </div>
            </div>

            <div class="product-card-promo__prices">
                <div class="product-card-promo__price">
                    <formatted-price
                        :value="minPrice"
                    ></formatted-price>
                </div>

                <div class="product-card-promo__old-price">
                    <formatted-price
                        :value="maxPrice"
                    ></formatted-price>
                </div>

                <div v-if="discount" class="product-card-promo__saving">
                    Вы экономите:
                    <formatted-price
                        :value="discount"
                    ></formatted-price>
                </div>
            </div>
        </div>

        <div class="product-card-promo__right">
            <div class="product-card-promo__actions text-right">
                <product-actions :product-id="product.id"></product-actions>
            </div>

            <a class="product-card-promo__link"
               :href="link"
               @mouseover="hover"
               @mouseleave="unHover"
            >
                <div class="product-card-promo__image-box">
                    <background-image-loader
                        v-if="image"
                        :key="image.id"
                        class="product-card-promo__image"
                        :screen="true"
                        :image="prepareImage(image.src)"
                        :retina-image="prepareImage(image.srcset)"
                        :reset="true"
                    ></background-image-loader>

                    <div v-else class="product-card-promo__image image-preview image-preview--1-1"></div>
                </div>
            </a>

            <div v-if="!isSmall && previews" class="product-card-promo__thumbs">
                <div class="product-thumbs">
                    <div class="product-thumbs__container d-flex">
                        <template v-for="image in previews">
                            <div :key="image.id" class="product-thumbs__item">
                                <div @click="setImage(image.id)" class="product-thumbs__btn">
                                    <background-image-loader
                                        class="product-thumbs__image"
                                        :image="prepareImage(image.src)"
                                        :retina-image="prepareImage(image.srcset)"
                                    ></background-image-loader>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="product-card-promo__quantity">
                <div class="product-remained">
                    Осталось

                    <span class="product-remained__num">
                        4
                        <span class="product-remained__circle"></span>
                    </span>

                    шт.
                </div>
            </div>

            <div class="product-card-promo__button">
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
    import Timer from '../../../../Timer'
    import Badge from '../../../badges/Badge'
    import ProductImagesHat from '../../../../../mixins/ProductImagesHat'
    import BackgroundImageLoader from '../../../../imageLoaders/BackgroundImageLoader'
    import ProductCardSaleMother from './ProductCardSaleMother'

    export default {
        name: "promo-card-sale-big",

        mixins: [
            mixin,
            ProductImagesHat
        ],

        components: {
            Timer,
            BackgroundImageLoader,
            Badge,
            ProductCardSaleMother
        },

        data() {
            return {
                image: false,
                linkIsHovered: false,
                isSmall: false,
            }
        },

        mounted() {
            if (this.previews) {
                this.image = this.previews[0]
            }

            this.$root.$on('resize', this.checkSize)
            this.checkSize()
        },

        methods: {
            setImage(id) {
                this.image = this.previews.find(image => image.id === id)
            },

            hover() {
                this.linkIsHovered = true
            },

            unHover() {
                this.linkIsHovered = false
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

            timerSize() {
                return this.product.sale.timeLeft < 86400 ? 'big' : 'medium'
            },
        }
    }
</script>
