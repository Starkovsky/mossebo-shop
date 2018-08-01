<template>
    <checkout-step
        title="Подтверждение"
    >
        <confirmation></confirmation>

        <template slot="back">
            <button @click="toStep('payment')" class="button button-light" :disabled="loading">
                <svg class="button__icon button__icon--left">
                    <use xlink:href="/assets/images/icons.svg#symbol-arrow-back"></use>
                </svg>

                Назад
            </button>
        </template>

        <template slot="forward">
            <button-loading
                @click="submit"
                :class="{'button': true, 'button-primary': !submitDisabled, 'button-light': submitDisabled}"
                :loading="loading"
                :disabled="submitDisabled"
            >
                Оформить заказ

                <svg class="button__icon button__icon--right">
                    <use xlink:href="/assets/images/icons.svg#symbol-cart"></use>
                </svg>
            </button-loading>
        </template>
    </checkout-step>
</template>

<script>
    // todo: Объяснить причину блокировки кнопки пользователю

    import { mapState } from 'vuex'

    import Mixin from './mixin'

    import CheckoutStep from './CheckoutStep'
    import Confirmation from '../../confirmation/Confirmation'
    import ButtonLoading from '../../../buttons/ButtonLoading'

    export default {
        name: "CheckoutStepPayment",

        mixins: [
            Mixin,
        ],

        components: {
            CheckoutStep,
            Confirmation,
            ButtonLoading
        },

        methods: {
            submit() {
                this.$store.dispatch('checkout/submit')
            }
        },

        computed: {
            ... mapState({
                loading: state => state.checkout.loading,
                submitDisabled(state) {
                    return (
                        ! state.cart.ready ||
                        state.cart.items.length === 0 ||
                        state.cart.loading ||
                        state.cart.error ||
                        state.checkout.loading ||
                        ! state.cart.synchronized ||
                        ! state.shipping.validated
                    )
                }
            })
        }
    }
</script>
