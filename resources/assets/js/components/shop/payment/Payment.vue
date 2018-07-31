<template>
    <div class="payment-page">
        <div class="payment-page__top">
            <span>Выберете способ оплаты</span>
        </div>

        <div class="payment-page__content">
            <div class="payment-page__choose">
                <payment-choose
                    :payments="types"
                    :active="activeType"
                    @choose="setType"
                ></payment-choose>
            </div>

            <div class="payment-page__info">
                Ссылку на оплату пришлет менеджер после подтверждения заказа.
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import PaymentChoose from './PaymentChoose'

    export default {
        name: "Payment",

        components: {
            PaymentChoose
        },

        methods: {
            setType(type) {
                this.$store.dispatch('payments/setType', type)
            }
        },

        computed: {
            ... mapState({
                types: state => {
                    return Object.keys(state.payments.types).reduce((acc, key) => {
                        acc[key] = state.payments.types[key].title
                        return acc
                    }, {})
                },
                activeType: state => state.payments.active,
            })
        }
    }
</script>
