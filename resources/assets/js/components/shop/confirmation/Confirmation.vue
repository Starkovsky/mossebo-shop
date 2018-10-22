<template>
    <div class="confirmation-page">
        <div class="confirmation-page__content">
            <confirmation-block
                icon="symbol-cart"
                title="Корзина"
                @change="setStep('cart')"
                :class="{'block-ui': !$root.isDesktop, 'success': cartStepDone, 'has-error': !cartStepDone}"
            >
                <transition name="fade" mode="out-in">
                    <div v-if="cartHasError" key="error">
                        <div :class="{'cart-error': true, 'block-ui': !$root.isDesktop}">
                            <h4>Ошибка соединения с сервером</h4>

                            <div class="cart-error__buttons">
                                <button class="button button-primary" @click="refresh">
                                    Попробовать еще раз
                                </button>
                            </div>
                        </div>
                    </div>

                    <div v-else-if="!cartIsReady" key="ready">
                        <loading
                            :loading="true"
                            :no-overlay="true"
                        ></loading>
                    </div>

                    <div v-else-if="cartIsEmpty" key="empty">
                        <div :class="{'cart-empty': true, 'block-ui': !$root.isDesktop}">
                            Корзина пуста.
                        </div>
                    </div>

                    <cart-table
                        v-else
                        :small="true"
                        :no-header="true"
                        :no-controls="true"
                    ></cart-table>
                </transition>
            </confirmation-block>

            <confirmation-block
                icon="symbol-person"
                title="Получатель"
                @change="setStep('shipping')"
                :class="{'block-ui': !$root.isDesktop, 'success': shippingStepDone, 'has-error': !shippingStepDone}"
            >
                <div class="confirmation-content-wrap">
                    <div v-if="dataIsEmpty(recipientData)" class="confirmation-empty">
                        Не заполнено.
                    </div>

                    <label-value-table
                        v-else
                        :data="recipientData"
                    ></label-value-table>
                </div>
            </confirmation-block>

            <confirmation-block
                icon="symbol-truck"
                title="Адрес доставки"
                @change="setStep('shipping')"
                :class="{'block-ui': !$root.isDesktop, 'success': shippingStepDone, 'has-error': !shippingStepDone}"
            >
                <div class="confirmation-content-wrap">
                    <div v-if="dataIsEmpty(shippingData)" class="confirmation-empty">
                        Не заполнено.
                    </div>

                    <label-value-table
                        v-else
                        :data="shippingData"
                    ></label-value-table>
                </div>
            </confirmation-block>

            <confirmation-block
                v-if="false"
                icon="symbol-credit-card"
                title="Оплата"
                @change="setStep('payment')"
                :class="{'block-ui': !$root.isDesktop, 'success': paymentStepDone, 'has-error': !paymentStepDone}"
            >

                <div class="confirmation-content-wrap">
                    <payment-item-info :payment-type="paymentType"></payment-item-info>
                </div>
            </confirmation-block>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapState } from 'vuex'
    import ConfirmationBlock from './ConfirmationBlock'
    import CartTable from '../cart/CartTable'
    import LabelValueTable from '../../LabelValueTable'
    import PaymentItemInfo from '../payment/PaymentItemInfo'
    import Loading from '../../Loading'

    export default {
        name: "Confirmation",

        components: {
            ConfirmationBlock,
            CartTable,
            LabelValueTable,
            PaymentItemInfo,
            Loading
        },

        methods: {
            refresh() {
                this.$store.dispatch('cart/refresh')
            },

            setStep(stepName) {
                this.$store.dispatch('checkout/set', stepName)
            },

            collectLabelData(labels = [], data) {
                return labels.reduce((acc, label) => {
                    if (data[label] !== '') {
                        acc.push({
                            label: this.$root.translate(`form.fields.${label}`),
                            value: data[label],
                            // onEmpty: 'hide'
                        })
                    }

                    return acc
                }, [])
            },

            dataIsEmpty(data) {
                for (let i = 0; i < data.length; i++) {
                    if (!_.isEmpty(data[i].value)) {
                        return false
                    }
                }

                return true
            },
        },

        computed: {
            ... mapState({
                recipientData({shipping}) {
                    return this.collectLabelData([
                        'first_name',
                        'last_name',
                        'email',
                        'phone'
                    ], shipping.data)
                },

                shippingData({shipping}) {
                    return this.collectLabelData([
                        'city',
                        'street',
                        'house_number',
                        'apartment',
                        'floor',
                        'entrance',
                        'intercom',
                        'post_code',
                        'comment',
                    ], shipping.data)
                },

                paymentType({payments}) {
                    return payments.active
                },

                shippingStepDone({shipping}) {
                    return shipping.validated
                },

                paymentStepDone() {
                    return true
                },

                cartHasError({cart}) {
                    return cart.error
                },

                cartIsReady({cart}) {
                    return cart.ready
                }
            }),

            ... mapGetters({
                cartIsEmpty: 'cart/isEmpty',
                cartStepNotDone: 'cart/stepNotDone'
            }),

            cartStepDone() {
                return !this.cartStepNotDone
            },

            recipientDataIsEmpty() {
                for (let i = 0; i < this.recipientData.length; i++) {
                    if (!_.isEmpty(this.recipientData[i].value)) {
                        return false
                    }
                }

                return true
            },


        }
    }
</script>
