<template>
    <div>
        <div class="product-card block-ui">
            <div class="product-card__actions text-right">
                <a href="#"
                   data-toggle="tooltip"
                   data-placement="top"
                   title="Данная функция в разработке"
                >
                    <svg class="symbol-icon symbol-wishlist">
                        <use xlink:href="/assets/images/icons.svg#symbol-wishlist"></use>
                    </svg>
                </a>

                <a href="#"
                   data-toggle="tooltip"
                   data-placement="top"
                   title="Данная функция в разработке"
                >
                    <svg class="symbol-icon symbol-heart">
                        <use xlink:href="/assets/images/icons.svg#symbol-heart"></use>
                    </svg>
                </a>
            </div>

            <a class="product-card__link"
               :href="link"
            >
                <div class="product-card__image-box">
                    <background-image-loader
                        class="product-card__image"
                        :screen="true"
                        :image="prepareImage(product.image.src)"
                        :retina-image="prepareImage(product.image.srcset)" />
                </div>

                <div class="product-card__name">
                    {{ product.name }}
                </div>
            </a>

            <div class="product-card__reviews">
                <img src="/assets/images/icons/stars.png" alt="">
                {{ getRandomInt(1,100) }}
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
                <!--<button-->
                    <!--type="button"-->
                    <!--class="button button-light"-->
                    <!--data-toggle="modal"-->
                    <!--data-target="#exampleModal"-->
                <!--&gt;-->
                    <!--Купить в один клик-->
                <!--</button>-->

                <a :href="link" class="button button-light">
                    Купить
                </a>
                <!-- <button type="button"
                        class="btn btn-outline-warning"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Добавить в корзину"
                >
                    <i class="md-icon">add_shopping_cart</i>
                </button>
                -->
            </div>
        </div>
    </div>
</template>

<script>
    import Core from '../../../scripts/core'
    import FormattedPrice from '../price/FormattedPrice'
    import BackgroundImageLoader from '../../imageLoaders/BackgroundImageLoader'
    import ProductImagesHat from '../../../mixins/ProductImagesHat'

    export default {
        name: "ProductCard",

        mixins: [
            ProductImagesHat
        ],

        props: [
            'product',
        ],

        mounted: function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('#exampleModal').on('shown.bs.modal', function () {
                $('#exampleModal').trigger('focus')
            })
        },

        components: {
            FormattedPrice,
            BackgroundImageLoader
        },

        methods: {
            getRandomInt: function(min, max) {
                let value = Math.floor(Math.random() * (max - min + 1)) + min;

                function declOfNum(value, titles) {
                    let cases = [2, 0, 1, 1, 1, 2];
                    return titles[ (value%100>4 && value%100<20)? 2 : cases[(value%10<5)?value%10:5] ];
                }

                return value + ' ' + declOfNum(value, ['отзыв', 'отзыва', 'отзывов'])
            }
        },

        computed: {
            link() {
                return Core.siteUrl('goods/' + this.product.id)
            }
        }
    }
</script>

<style lang="scss" scoped>

    @import "../../../../sass/variables/colors";
    @import "../../../../sass/variables/variables";

    @keyframes animate-buttons {
        from {height: 0;}
        to {height: auto;}
    }

    .product-card {
        width: 100%;
        padding: 20px;
        margin: 15px 0;
        height: 420px;
        box-sizing: border-box;
        transition: $transition-primary;
        //display: flex;
        //flex-direction: column;
        //justify-content: space-between;
        &:hover {
            box-shadow: $shadows-hover;
            margin-top: 0;
            margin-bottom: 0;
            height: (420px + 30px);
            .product-card__buttons {
                //opacity: 1;
                //display: flex;
                height: auto;
                animation-name: animate-buttons;
                animation-duration: 0.3s;
            }
        }
        &__actions {
            margin-bottom: 0px;
            a {
                display: inline-block;
                .symbol-icon {
                    fill: $color-icons;
                    transition: $transition-primary;
                }
                &:hover {
                    .symbol-icon {
                        fill: $color-text-primary;
                    }
                }
            }
        }
        &__link {
            color: $color-text-primary;
            &:hover {
                color: $color-primary;
                text-decoration: none;
            }
        }
        &__image {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background-size: contain;
            background-position: center center;
            background-repeat: no-repeat;
            &-box {
                display: block;
                position: relative;
                width: 100%;
                max-width: 200px;
                margin-left: auto;
                margin-right: auto;
                margin-bottom: 5px;
                &:before {
                    content: "";
                    display: block;
                    padding-top: 100%;
                }
            }
        }
        &__name {
            display: block;
            font-size: 14px;
            line-height: 18px;
            font-weight: 400;
            margin-bottom: 10px;
            transition: 0.2s;
            height: 36px;
            overflow: auto;
        }
        &__reviews {
            font-size: 12px;
            vertical-align: middle;
            color: $color-text-secondary;
            img {
                float: left;
                margin-right: 10px;
            }
        }
        &__price {
            font-size: 18px;
            font-weight: 500;
            color: $color-text-primary;
        }
        &__old-price {
            font-size: 14px;
            font-weight: 400;
            height: 22px;
            color: $color-text-secondary;
            text-decoration: line-through;
        }
        &__buttons {
            //opacity: 0;
            //display: none;
            height: 0;
            overflow: hidden;
            margin-top: 15px;
            text-align: center;
            .button {
                width: 100%;
                text-align: center;
                max-width: 300px;
                margin-left: auto;
                margin-right: auto;
            }
        }
    }

</style>
