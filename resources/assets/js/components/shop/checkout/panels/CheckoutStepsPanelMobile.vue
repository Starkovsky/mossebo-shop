<template>
    <div class="checkout-steps-panel-mobile">
        <div class="checkout-steps-panel-mobile__left">
            <div class="back-link" @click="prevStep">
                <svg class="back-link__icon">
                    <use xlink:href="/assets/images/icons.svg#symbol-chevron-left"></use>
                </svg>

                <template v-if="this.current === 1">
                    На главную
                </template>

                <template v-else>
                    Назад
                </template>
            </div>
        </div>

        <div class="checkout-steps-panel-mobile__right">
            Шаг&nbsp;&nbsp;{{ current }}&nbsp;&nbsp;из&nbsp;&nbsp;{{ total }}
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import mixin from './mixin'

    export default {
        name: "CheckoutStepsPanelMobile",

        props: {
            active: String
        },

        mixins: [
            mixin
        ],

        methods: {
            isActive(step) {
                return step.identif === this.activeTab
            },

            prevStep() {
                if (this.current === 1) {
                    window.location.href = '/'
                }
                else {
                    this.$store.dispatch('checkout/prev')
                }
            }
        },

        computed: {
            total() {
                return this.steps.length
            },

            ... mapState({
                current: state => state.checkout.active + 1
            })
        }
    }
</script>
