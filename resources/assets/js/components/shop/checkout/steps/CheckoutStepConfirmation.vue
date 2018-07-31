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

    import { mapState } from 'vuex'

    import Core from '../../../../scripts/core'

    import Mixin from './mixin'

    import CheckoutStep from './CheckoutStep'
    import Confirmation from '../../confirmation/Confirmation'
    import ButtonLoading from '../../../buttons/ButtonLoading'
    import RequestMixin from '../../../../mixins/RequestMixin'
    import { LocalStorageProxy } from '../../../../scripts/LocalStorageProxy'

    let shippingStorage = new LocalStorageProxy('__shipping')
    let cartStorage = new LocalStorageProxy('__cart')

    export default {
        name: "CheckoutStepPayment",

        mixins: [
            Mixin,
            RequestMixin
        ],

        components: {
            CheckoutStep,
            Confirmation,
            ButtonLoading
        },

        data() {
            return {
                request: '',
                loading: false,
                errorCounter: 0,
            }
        },

        methods: {
            submit() {
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
                    pay_type: state.payments.active
                }

                this.sendRequest('post', Core.siteUrl('checkout'), data)
                    .success(response => {
                        shippingStorage.forgetAll()
                        cartStorage.forgetAll()

                        window.location.href = Core.siteUrl('checkout/thanks/' + response.data.orderId)
                    })
                    .fail(() => {
                        if (++ this.errorCounter > 2) {
                            window.location.reload()
                        }
                    })
            }
        },

        computed: {
            ... mapState({
                submitDisabled(state) {
                    return (
                        ! state.cart.ready ||
                        state.cart.items.length === 0 ||
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
