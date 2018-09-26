<template>
    <div :class="{
        'product-card-promo block-ui block-ui--with-hover': true,
        'product-card-promo--small': isSmall,
        'product-card-promo--link-hover': linkIsHovered
    }">

        <template v-if="isSmall">
            <div>
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

                <div class="product-card-promo__actions text-right">
                    <product-actions></product-actions>
                </div>

                <div class="product-card-promo__timer">
                    <div class="product-card-promo__timer-label">
                        До конца акции:
                    </div>

                    <timer
                        :time="getSaleTime()"
                        :class-name-modificators="'medium'"
                    ></timer>
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
                            :image="prepareImage(image.small.src)"
                            :retina-image="prepareImage(image.small.srcset)"
                            :reset="true"
                        ></background-image-loader>

                        <div v-else class="product-card-promo__image"></div>
                    </div>
                </a>

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
                </div>
            </div>
        </template>

        <template v-else>
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
                                :time="getSaleTime()"
                                :class-name-modificators="getSaleTime() < 86400 ? 'big' : 'medium'"
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

                    <div v-if="saving" class="product-card-promo__saving">
                        Вы экономите:
                        <formatted-price
                            :value="saving"
                        ></formatted-price>
                    </div>
                </div>
            </div>

            <div class="product-card-promo__right">
                <div class="product-card-promo__actions text-right">
                    <product-actions></product-actions>
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
                            :image="prepareImage(image.small.src)"
                            :retina-image="prepareImage(image.small.srcset)"
                            :reset="true"
                        ></background-image-loader>

                        <div v-else class="product-card-promo__image"></div>
                    </div>
                </a>

                <div v-if="!isSmall && product.images && product.images.length > 0" class="product-card-promo__thumbs">
                    <div class="product-thumbs">
                        <div class="product-thumbs__container d-flex">
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
        </template>
    </div>
</template>

<script>
    import mixin from './mixin'
    import Timer from '../../../Timer'
    import ProductImagesHat from '../../../../mixins/ProductImagesHat'
    import BackgroundImageLoader from '../../../imageLoaders/BackgroundImageLoader'
    import Badge from '../../badges/Badge'

    export default {
        name: "ProductCardSaleSmall",

        mixins: [
            mixin,
            ProductImagesHat
        ],

        components: {
            Timer,
            BackgroundImageLoader,
            Badge
        },

        props: {
            saleTime: null,
            small: {
                type: Boolean,
                default: false,
            }
        },

        data() {
            return {
                image: false,
                linkIsHovered: false,
                isSmall: false,
                startTime: null,
            }
        },

        created() {
            this.startTime = performance.now()
        },

        mounted() {
            if (this.images.length) {
                this.image = this.images[0]
            }

            this.$root.$on('resize', this.checkSize)
            this.checkSize()
        },

        methods: {
            setImage(id) {
                this.image = this.product.images.find(image => image.id === id)
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

            getSaleTime() {
                return this.saleTime - parseInt((performance.now() - this.startTime) / 1000)
            }
        },

        computed: {
            images() {
                if (! (this.product && this.product.images && this.product.images.length)) return []

                return this.product.images.slice(0, 3)
            },

            maxPrice() {
                return this.product.old_price ? this.product.old_price : this.product.price
            },

            minPrice() {
                return this.product.sale_price
            },

            discountPercent() {
                let discount = (this.maxPrice - this.minPrice) / this.maxPrice * 100

                return '-&thinsp;' + discount.toFixed(0) + '&thinsp;%'
            },

            saving() {
                if (this.maxPrice > this.minPrice) {
                    return this.maxPrice - this.minPrice
                }
            }
        }
    }
</script>
