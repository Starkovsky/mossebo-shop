<template>
    <div>
        <div class="product-card">
            <div class="product-card__actions text-right">
                <a href="#"
                   data-toggle="tooltip"
                   data-placement="top"
                   title="Добавить в сравнение"
                >
                    <i class="md-icon">playlist_add</i>
                </a>
                <a href="#"
                   data-toggle="tooltip"
                   data-placement="top"
                   title="Добавить в избранное"
                >
                    <i class="md-icon">favorite</i>
                </a>
            </div>
            <div class="product-card__image-box">
                <div class="product-card__image"
                     :style="{ 'background-image': 'url(' + product.image + ')' }"
                >
                </div>
            </div>
            <div class="product-card__name">
                {{ product.name }}
            </div>
            <div class="product-card__price">
                {{ PriceWithSeparation(product.price) }} &#8381;
            </div>
            <div class="product-card__old-price" v-if="product.old_price > 0">
                {{ PriceWithSeparation(product.old_price) }} &#8381;
            </div>
            <div class="product-card__buttons">
                <button type="button"
                        class="button button-light btn-block"
                >
                    Купить в 1 клик
                </button>
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
    import PriceWithSeparation from '../../mixins/PriceWithSeparation'

    export default {
        name: "ProductCard",
        props: [
            'product',
        ],
        mixins: [
            PriceWithSeparation,
        ],
        mounted: function () {
            $('[data-toggle="tooltip"]').tooltip();
        }
    }
</script>

<style lang="scss" scoped>

    @import "../../../sass/variables/colors";
    @import "../../../sass/variables/variables";

    @keyframes animate-buttons {
        from {height: 0;}
        to {height: auto;}
    }

    .product-card {
        width: 100%;
        background: $color-ui;
        padding: 20px;
        margin: 15px 0;
        border-radius: 5px;
        box-shadow: $shadows-primary;
        height: 430px;
        box-sizing: border-box;
        transition: $transition-primary;
        //display: flex;
        //flex-direction: column;
        //justify-content: space-between;
        &:hover {
            box-shadow: $shadows-hover;
            cursor: pointer;
            margin-top: 0;
            margin-bottom: 0;
            height: (430px + 30px);
            .product-card__buttons {
                //opacity: 1;
                //display: flex;
                height: auto;
                animation-name: animate-buttons;
                animation-duration: 0.3s;
            }
        }
        &__actions {
            a {
                color: $color-icons;
                display: inline-block;
                &:hover {
                    color: $color-text-primary;
                }
            }
        }
        &__image {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background-size: 100% auto;
            background-position: center center;
            &-box {
                position: relative;
                width: 100%;
                max-width: 200px;
                margin-left: auto;
                margin-right: auto;
                &:before {
                    content: "";
                    display: block;
                    padding-top: 100%;
                }
            }
        }
        &__name {
            font-size: 14px;
            font-weight: 400;
            color: $color-text-primary;
            margin-top: 10px;
            padding-bottom: 10px;
            transition: 0.2s;
            height: 76px;
            &:hover {
                color: $color-primary;
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
            color: $color-text-secondary;
            text-decoration: line-through;
        }
        &__buttons {
            //opacity: 0;
            //display: none;
            height: 0;
            overflow: hidden;
            margin-top: 15px;
            .button {
                width: 100%;
                text-align: center;
            }
        }
    }

</style>
