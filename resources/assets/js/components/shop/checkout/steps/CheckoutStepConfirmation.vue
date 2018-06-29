<template>
    <checkout-step
        title="Подтверждение"
    >
        <confirmation></confirmation>

        <template slot="back">
            <button @click="toStep('payment')" class="button button-light">
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

    import axios from 'axios'
    import { mapState } from 'vuex'

    import Core from '../../../../scripts/core'

    import Mixin from './mixin'

    import CheckoutStep from './CheckoutStep'
    import Confirmation from '../../confirmation/Confirmation'
    import ButtonLoading from '../../../buttons/ButtonLoading'

    export default {
        name: "CheckoutStepPayment",

        mixins: [
            Mixin
        ],

        components: {
            CheckoutStep,
            Confirmation,
            ButtonLoading
        },

        data() {
            return {
                loading: false
            }
        },

        methods: {
            submit() {
                if (this.loading) return

                this.loading = true

                let state = this.$store.state

                let data = {
                    cart: state.cart.items.reduce((acc, item) => {
                        acc[item.key] = item.qty
                        return acc
                    }, {}),
                    shipping: {
                        type: state.shipping.type,
                        data: {... state.shipping.data}
                    },
                    payment: state.payments.type
                }

                axios.post(Core.siteUrl('checkout'), data)
                    .then(response => {
                        window.location.href = Core.siteUrl('checkout/thanks')
                    })
                    .catch(response => {
                        // todo: ДОДЕЛАТЬ!
                        alert('Ошибка. Попробуйте позднее.')
                        window.location.reload()
                        console.log(response)

                        this.loading = false
                    })
            }
        },

        computed: {
            ... mapState({
                submitDisabled(state) {
                    return (
                        ! state.cart.ready ||
                        state.cart.loading ||
                        state.cart.error ||
                        ! state.cart.synchronized ||
                        ! state.shipping.validated
                    )
                }
            })
        }
    }
</script>
