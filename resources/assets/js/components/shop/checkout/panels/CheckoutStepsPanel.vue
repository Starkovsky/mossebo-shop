<template>
    <div class="checkout-steps-panel block-ui">
        <div class="row">
            <template v-for="step in steps">
                <div :key="step.identif" class="col-xs-6 col-sm-6 col-md-6 col-lg-3">
                    <div :class="{'checkout-step-badge': true, 'is-active': isActive(step)}">
                        <div @click="setStep(step.identif)" class="checkout-step-badge__icon">
                            <svg>
                                <use :xlink:href="`/assets/images/icons.svg#${step.icon}`"></use>
                            </svg>
                        </div>
                        <div class="checkout-step-badge__info">
                            <div class="checkout-step-badge__name">
                                {{ step.stepName }}
                            </div>

                            <div class="checkout-step-badge__title">
                                {{ step.title }}
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import mixin from './mixin'

    export default {
        name: "CheckoutStepsPanel",

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

            setStep(step) {
                this.$store.dispatch('checkout/set', step)
            },

            ... mapGetters({
                activeTab: 'checkout/activeTab'
            })
        },
    }
</script>
