<template>
    <div :class="{'cart-product-item': true, 'cart-product-item--ghost': isGhost, 'block-ui': true}">
        <div class="cart-product-item__top">
            <product-short-description
                :product="product"
                :small="small"
            ></product-short-description>
        </div>

        <div class="cart-product-item__bottom">
            <div class="cart-product-item__num">
                <template v-if="noControls">
                    {{ product.quantity }}&nbsp;шт
                </template>

                <num-control
                    v-else
                    :number="product.quantity"
                    @update:number="changeQty"
                    :small="small"
                    :min="1"
                    :max="99"
                ></num-control>
            </div>

            <div class="cart-product-item__total">
                <formatted-price
                    v-if="totalPrice"
                    :value="totalPrice"
                ></formatted-price>
            </div>

            <div v-if="!noControls" class="cart-product-item__trash">
                <button class="cart-trash-btn cart-table__ghost-focus" @click="remove">
                    <svg class="symbol-icon">
                        <use xlink:href="/assets/images/icons.svg#symbol-trash"></use>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import ProductMixin from './mixin'

    export default {
        name: "CartProductItem",

        mixins: [
            ProductMixin
        ]
    }
</script>
