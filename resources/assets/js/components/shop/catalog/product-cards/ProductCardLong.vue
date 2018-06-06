<template>
    <div :class="{'product-card-long block-ui': true, 'link-is-hovered': linkIsHovered}">
        <div class="product-card-long__actions text-right">
            <product-actions></product-actions>
        </div>

        <div class="product-card-long__image-box">
            <a class="product-card-long__link" :href="link" @mouseenter="hoverLink" @mouseout="unHoverLink">
                <background-image-loader
                    v-if="product.image"
                    class="product-card-long__image"
                    :screen="true"
                    :image="prepareImage(product.image.src)"
                    :retina-image="prepareImage(product.image.srcset)"
                ></background-image-loader>
            </a>
        </div>

        <div class="product-card-long__center">
            <div class="product-card-long__name">
                <a class="product-card-long__link" :href="link" @mouseenter="hoverLink" @mouseout="unHoverLink">
                    {{ product.name }}
                </a>
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
                <a :href="link" class="button button-light">
                    Подробнее
                </a>
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
                linkIsHovered: false
            }
        },

        methods: {
            hoverLink() {
                this.linkIsHovered = true
            },

            unHoverLink() {
                this.linkIsHovered = false
            },
        }
    }
</script>
