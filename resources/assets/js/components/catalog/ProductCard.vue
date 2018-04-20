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
            <a class="product-card__image-box"
               :href="'/' + this.$root.language + '/goods/' + product.id"
            >
                <div class="product-card__image"
                     :style="{ 'background-image': 'url(' + 'https://admin.mossebo.market' + product.image + ')' }"
                >
                </div>
            </a>
            <a class="product-card__name"
               :href="'/' + this.$root.language + '/goods/' + product.id"
            >
                {{ product.name }}
            </a>
            <div class="product-card__reviews">
                <img src="/assets/images/icons/stars.png" alt="">
                32 отзыва
            </div>
            <div class="product-card__price">
                {{ PriceWithSeparation(product.price) }} &#8381;
            </div>
            <div class="product-card__old-price">
                <span v-if="product.old_price > 0">
                    {{ PriceWithSeparation(product.old_price) }} &#8381;
                </span>
            </div>
            <div class="product-card__buttons">
                <button type="button"
                        class="button button-light"
                        data-toggle="modal"
                        data-target="#exampleModal"
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
            $('#exampleModal').on('shown.bs.modal', function () {
                $('#exampleModal').trigger('focus')
            })
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
        height: 420px;
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
            margin-bottom: 20px;
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
                margin-bottom: 25px;
                &:before {
                    content: "";
                    display: block;
                    padding-top: 80%;
                }
            }
        }
        &__name {
            display: block;
            font-size: 14px;
            line-height: 18px;
            font-weight: 400;
            color: $color-text-primary;
            margin-bottom: 10px;
            transition: 0.2s;
            height: 36px;
            overflow: auto;
            &:hover {
                color: $color-primary;
                text-decoration: none;
            }
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
