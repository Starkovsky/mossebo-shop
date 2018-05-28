<template>
    <div class="checkout">
        <div class="checkout__steps">
            <checkout-steps
                active="cart"
            ></checkout-steps>
        </div>

        <div class="py-3"></div>

        <div class="checkout__content">
            <transition
                :name="animationName"
                @beforeEnter="beforeEnter"
                @beforeLeave="beforeLeave"
            >
                <div
                    v-if="isActive('cart')"
                    key="cart"
                    class="checkout__item"
                >
                    <cart></cart>
                </div>

                <div
                    v-if="isActive('shipping')"
                    key="shipping"
                    class="checkout__item"
                >
                    <shipping></shipping>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapState } from 'vuex'

    import Cart from "../cart/Cart"
    import Shipping from "../shipping/Shipping"
    import CheckoutSteps from './CheckoutSteps'

    export default {
        name: "Checkout",

        components: {
            CheckoutSteps,
            Cart,
            Shipping
        },

        methods: {
            isActive(tab) {
                return tab === this.activeTab
            },

            beforeEnter(el) {
                console.log('enter', el)

                el.classList.add('enter')
            },

            beforeLeave(el) {
                console.log('leave', el)

                el.classList.add('leave')
            }
        },

        computed: {
            ... mapState({
                steps: state => state.checkout.steps,
                animationName: state => 'slide-' + state.checkout.direction
            }),

            ... mapGetters({
                activeTab: 'checkout/activeTab'
            })
        }
    }
</script>
