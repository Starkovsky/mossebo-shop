<template>
    <checkout-step
        title="Корзина"
    >
        <cart></cart>

        <template slot="back">
            <a href="/" class="button button-light">
                <!--<svg class="button__icon button__icon&#45;&#45;left">-->
                    <!--<use xlink:href="/assets/images/icons.svg#symbol-arrow-back"></use>-->
                <!--</svg>-->

                На главную
            </a>
        </template>

        <template slot="forward">
            <button @click="toStep('shipping')" :class="{button: true, 'button-primary': !nextDisabled, 'button-light': nextDisabled}" :disabled="nextDisabled">
                Оформить заказ

                <svg class="button__icon button__icon--right">
                    <use xlink:href="/assets/images/icons.svg#symbol-arrow-forward"></use>
                </svg>
            </button>
        </template>
    </checkout-step>
</template>

<script>
    import { mapGetters, mapState } from 'vuex'

    import Mixin from './mixin'

    import CheckoutStep from './CheckoutStep'
    import Cart from "../../cart/Cart"

    export default {
        name: "CheckoutStepCart",

        mixins: [
            Mixin
        ],

        components: {
            Cart,
            CheckoutStep
        },

        methods: {

        },

        computed: {
            ... mapGetters({
                nextDisabled: 'cart/stepNotDone'
            }),
        }
    }


</script>
