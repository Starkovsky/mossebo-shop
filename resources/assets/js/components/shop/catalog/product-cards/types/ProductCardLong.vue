<template>
    <div :class="{'product-card-long block-ui block-ui--with-hover': true, 'link-is-hovered': linkIsHovered}">
        <div class="product-card-long__actions text-right">
            <product-actions></product-actions>
        </div>

        <a
            class="product-card-long__link"
            :href="link"
            @mouseover="hover"
            @mouseleave="unHover"
        >
            <div class="product-card-long__image-box">
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
                        class="product-card-long__image"
                        :image="image"
                        :no-image-loading="noImageLoading"
                    ></product-card-image>
                </template>
            </div>
        </a>

        <div class="product-card-long__center">
            <div class="">
                <div class="product-card-long__name">
                    <a class="product-card-long__link" :href="link" @mouseover="hover" @mouseleave="unHover">
                        {{ product.name }}
                    </a>
                </div>

                <div v-if="product.badges" class="product-card-long__badges">
                    <badges
                        :badges="product.badges.slice(0,2)"
                    ></badges>
                </div>
            </div>


            <div class="product-card-long__short-desc">
                <div class="product-param">
                    Артикул:
                    <span class="product-param__value">{{ product.id }}</span>
                </div>

                <div class="product-param">
                    Наличие:
                    <span class="product-param__value">Под заказ</span>
                </div>

                <div class="product-param">
                    Срок поставки:
                    <span class="product-param__value">14 дней</span>
                </div>
            </div>
        </div>

        <div class="product-card-long__right">
            <div>
                <div class="product-card-long__price">
                    <formatted-price
                        :value="product.price"
                    ></formatted-price>
                </div>

                <div v-if="product.old_price" class="product-card-long__old-price">
                    <formatted-price
                        :value="product.old_price"
                    ></formatted-price>
                </div>

                <div class="product-card-long__rating">
                    <rating></rating>
                </div>
            </div>


            <div class="product-card-long__buttons">
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
        name: "ProductCardLong",

        mixins: [
            mixin
        ],

        data() {
            return {
                linkIsHovered: false,
            }
        },

        methods: {
            hover() {
                this.linkIsHovered = true
            },

            unHover() {
                this.linkIsHovered = false
            },
        },
    }
</script>
