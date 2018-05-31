<template>
    <checkout-step
        title="Оплата"
    >
        <payment></payment>

        <template slot="back">
            <button @click="toStep('shipping')" class="button button-light">
                <svg class="button__icon button__icon--left">
                    <use xlink:href="/assets/images/icons.svg#symbol-arrow-back"></use>
                </svg>

                Назад
            </button>
        </template>

        <template slot="forward">
            <button @click="toStep('confirmation')" class="button button-primary">
                Подтвердить заказ

                <svg class="button__icon button__icon--right">
                    <use xlink:href="/assets/images/icons.svg#symbol-arrow-forward"></use>
                </svg>
            </button>
        </template>
    </checkout-step>
</template>

<script>
    import Mixin from './mixin'

    import CheckoutStep from './CheckoutStep'
    import Payment from "../../payment/Payment"

    export default {
        name: "CheckoutStepPayment",

        mixins: [
            Mixin
        ],

        components: {
            CheckoutStep,
            Payment
        },
    }
</script>
