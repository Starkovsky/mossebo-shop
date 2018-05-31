<template>
    <div class="payment-page">
        <div class="payment-page__top">
            <span>Выберете способ оплаты</span>
        </div>

        <div class="payment-page__content">
            <div class="payment-page__choose">
                <div class="row">
                    <template v-for="(title, type) in types">
                        <div class="payment-page__option col-sm-12 col-md-6">
                            <input type="radio" name="payment" :id="`payment-${type}`" :checked="isActive(type)" style="display: none;">
                            <label class="huge-radio" :for="`payment-${type}`" @click="setType(type)">
                                {{ title }}
                            </label>
                        </div>
                    </template>
                </div>
            </div>

            <div class="payment-page__info">
                Ссылку на оплату пришлет менеджер после подтверждения заказа.
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        name: "Payment",

        methods: {
            isActive(type) {
                return this.activeType === type
            },

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
                activeType: state => state.payments.type,
            })
        }
    }
</script>
