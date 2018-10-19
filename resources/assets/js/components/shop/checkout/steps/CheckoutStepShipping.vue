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
                    Перейти к оплате

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
                validationLoading: false
            }
        },

        created() {
            this.__validateDebouncer = _.debounce(() => {
                this.validate()
            }, 300)

            this.validateDebouncer = () => {
                this.validationLoading = true
                this.__validateDebouncer()
            }

            // this.unsubscriber = this.$store.subscribe(mutation => {
            //     if (mutation.type === 'shipping/SHIPPING_SET_VALUE') {
            //         this.validateDebouncer()
            //     }
            // })
        },

        mounted() {
            this.validate(this.$store.state.checkout.direction !== 'back', false)
        },

        beforeDestroy() {
            this.validateDebouncer = null
            this.__validateDebouncer = null

            if (_.isFunction(this.unsubscriber)) {
                this.unsubscriber()
            }

            this.unsubscriber = null
        },

        methods: {
            validate(silent = true, showLoading = true) {
                if (!this.validationLoading && showLoading) {
                    this.validationLoading = true
                }

                this.$refs.shippingComponent.$validator.validateAll(undefined, undefined, silent)
                    .then(result => {
                        this.validationLoading = false
                        this.nextDisabled = !result
                        this.$store.dispatch('shipping/validation', result)
                    })
            },

            showValidationErrors() {
                this.validate(false, false)
            }
        },
    }
</script>
