<template>
    <div class="checkout js-checkout">
        <div class="checkout__steps js-checkout-steps">
            <template v-if="$root.isDesktop">
                <checkout-steps-panel></checkout-steps-panel>
            </template>

            <template v-else>
                <checkout-steps-panel-mobile></checkout-steps-panel-mobile>
            </template>
        </div>

        <div class="py-3"></div>

        <div :class="{'block-ui': $root.isDesktop}">
            <div class="checkout__wrap js-checkout-wrap">
                <div class="checkout__content">
                    <transition
                        :name="animationName"
                        @before-leave="beforeLeave"
                        @enter="enter"
                        @after-enter="afterEnter"
                    >
                        <div
                            v-if="isActive('cart')"
                            key="cart"
                            class="checkout__item"
                        >
                            <checkout-step-cart></checkout-step-cart>
                        </div>

                        <div
                            v-if="isActive('shipping')"
                            key="shipping"
                            class="checkout__item"
                        >
                            <checkout-step-shipping></checkout-step-shipping>
                        </div>

                        <div
                            v-if="isActive('payment')"
                            key="payment"
                            class="checkout__item"
                        >
                            <checkout-step-payments></checkout-step-payments>
                        </div>

                        <div
                            v-if="isActive('confirmation')"
                            key="confirmation"
                            class="checkout__item"
                        >
                            <checkout-step-confirmation></checkout-step-confirmation>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapState } from 'vuex'

    import CheckoutStepsPanel from './panels/CheckoutStepsPanel'
    import CheckoutStepsPanelMobile from './panels/CheckoutStepsPanelMobile'

    import CheckoutStepCart from './steps/CheckoutStepCart'
    import CheckoutStepShipping from './steps/CheckoutStepShipping'
    import CheckoutStepPayments from './steps/CheckoutStepPayments'
    import CheckoutStepConfirmation from './steps/CheckoutStepConfirmation'

    import VeeValidate from 'vee-validate'
    import Vue from 'vue'

    export default {
        name: "Checkout",

        components: {
            CheckoutStepsPanel,
            CheckoutStepsPanelMobile,
            CheckoutStepCart,
            CheckoutStepShipping,
            CheckoutStepPayments,
            CheckoutStepConfirmation
        },

        created() {
            Vue.use(VeeValidate, {
                fieldsBagName: 'formFields',
                errorBagName: 'formErrors'
            })

            this.$store.dispatch('checkout/init')
            this.$store.dispatch('cart/init')
            this.$store.dispatch('shipping/init')
            this.$store.dispatch('payments/init')
        },

        methods: {
            isActive(tab) {
                return tab === this.activeTab
            },

            getWrapEl() {
                return this.$el.querySelector('.js-checkout-wrap')
            },

            beforeLeave(el) {
                let wrapEl = this.getWrapEl()
                wrapEl.classList.add('animation-in-process')

                this.$nextTick(() => {
                    wrapEl.style.height = el.clientHeight + 'px'
                })
            },

            enter(el) {
                let wrapEl = this.getWrapEl()

                this.$nextTick(() => {
                    wrapEl.style.height = el.clientHeight + 'px'
                })
            },

            afterEnter() {
                let wrapEl = this.getWrapEl()
                wrapEl.classList.remove('animation-in-process')

                this.$nextTick(() => {
                    wrapEl.style.height = 'auto'
                })
            },
        },

        computed: {
            ... mapState({
                steps: state => state.checkout.steps,
                animationName: state => 'slide-' + state.checkout.direction
            }),

            ... mapGetters({
                activeTab: 'checkout/activeTab'
            }),
        }
    }
</script>
