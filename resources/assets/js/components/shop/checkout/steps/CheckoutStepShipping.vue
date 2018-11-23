<template>
    <checkout-step
        title="Доставка"
    >
        <shipping
            ref="shippingComponent"
            :class="{'block-ui': !$root.isDesktop}"
        ></shipping>

        <template slot="back">
            <button @click="toStep('cart')" class="button button-light">
                <svg class="button__icon button__icon--left">
                    <use xlink:href="/assets/images/icons.svg#symbol-arrow-back"></use>
                </svg>

                Назад
            </button>
        </template>

        <template slot="forward">
            <template v-if="nextDisabled">
                <button-loading
                    @click="showValidationErrors"
                    class="button button-light"
                    :loading="validationLoading"
                    :disabled="validationLoading"
                >
                    Подтвердить заказ

                    <svg class="button__icon button__icon--right">
                        <use xlink:href="/assets/images/icons.svg#symbol-arrow-forward"></use>
                    </svg>
                </button-loading>
            </template>

            <template v-else>
                <button-loading
                    @click="toStep('confirmation')"
                    class="button button-primary"
                    :loading="validationLoading"
                    :disabled="validationLoading"
                >
                    Подтвердить заказ

                    <svg class="button__icon button__icon--right">
                        <use xlink:href="/assets/images/icons.svg#symbol-arrow-forward"></use>
                    </svg>
                </button-loading>
            </template>
        </template>


    </checkout-step>
</template>

<script>
    import Mixin from './mixin'

    import CheckoutStep from './CheckoutStep'
    import Shipping from '../../shipping/Shipping'
    import ButtonLoading from '../../../buttons/ButtonLoading'

    export default {
        name: "CheckoutStepShipping",

        mixins: [
            Mixin
        ],

        components: {
            CheckoutStep,
            Shipping,
            ButtonLoading
        },

        data() {
            return {
                nextDisabled: true,
                validationLoading: false,
                hasChanged: false,
                validationDebouncer: null,
                unsubscriber: null,
            }
        },

        created() {
            this.validationDebouncer = _.debounce((silent, showLoading) => {
                this.validate(silent, showLoading)
            }, 128)

            this.unsubscriber = this.$store.subscribe(mutation => {
                if (mutation.type === 'shipping/SHIPPING_SET_VALUE') {
                    this.hasChanged = true
                }
            })
        },

        mounted() {
            this.validationDebouncer(this.$store.state.checkout.direction !== 'back', true)

            ;[].forEach.call(this.$el.querySelectorAll('[name]'), el => {
                el.addEventListener('blur', () => {
                    if (this.hasChanged) {
                        this.hasChanged = false
                        this.validationDebouncer()
                    }
                }, {passive: true})
            })
        },

        beforeDestroy() {
            this.validationDebouncer = null
            this.unsubscriber()
        },

        methods: {
            validate(silent = true, showLoading = true) {
                if (!this.validationLoading && showLoading) {
                    this.validationLoading = true
                }

                let shippingComponent = this.$refs.shippingComponent

                if (! shippingComponent) return

                shippingComponent.$validator.validateAll(undefined, undefined, silent)
                    .then(result => {
                        this.validationLoading = false
                        this.nextDisabled = ! result
                        this.$store.dispatch('shipping/validation', result)
                    })
            },

            showValidationErrors() {
                this.validationDebouncer(false, false)
            }
        },
    }
</script>
