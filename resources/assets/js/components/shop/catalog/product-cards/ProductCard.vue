<template>
    <div class="product-card block-ui block-ui--with-hover">
        <div class="product-card__actions text-right">
            <product-actions></product-actions>
        </div>

        <a class="product-card__link"
           :href="link"
        >
            <div class="product-card__image-box">
                <product-card-image
                    class="product-card__image"
                    :image="product.image"
                    :no-image-loading="noImageLoading"
                ></product-card-image>
            </div>

            <div class="product-card__name">
                {{ product.name }}
            </div>
        </a>

        <div class="product-card__reviews">
            <rating></rating>
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
            <a :href="link" class="button button-light">
                Подробнее
            </a>
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
