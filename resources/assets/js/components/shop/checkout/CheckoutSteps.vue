<template>
    <div class="checkout-steps block-ui">
        <div class="row">
            <template v-for="step in steps">
                <div :key="step.identif" class="col-xs-6 col-sm-6 col-md-6 col-lg-3">
                    <div :class="{'checkout-step': true, 'is-active': isActive(step)}">
                        <div class="checkout-step__icon">
                            <svg>
                                <use :xlink:href="`/assets/images/icons.svg#${step.icon}`"></use>
                            </svg>
                        </div>
                        <div class="checkout-step__info">
                            <div class="checkout-step__name">
                                {{ step.stepName }}
                            </div>

                            <div class="checkout-step__title">
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
    import { mapGetters, mapState } from 'vuex'

    export default {
        name: "CheckoutSteps",

        props: {
            active: String
        },

        methods: {
            isActive(step) {
                return step.identif === this.activeTab
            },
        },

        computed: {
            ... mapState({
                steps: state => state.checkout.steps,
            }),

            ... mapGetters({
                activeTab: 'checkout/activeTab'
            })
        }
    }
</script>

<style lang="scss" scoped>
    @import "../../../../sass/variables/colors";

    .checkout-steps {
        padding: 30px 20px;

        @media (min-width: 768px) {
            padding: 20px 30px;
        }

        @media (min-width: 1200px) {
            padding: 20px 85px;
        }

        & .row {
            margin-right: -5px;
            margin-left: -5px;

            & > div {
                padding: 0 5px;
            }
        }
    }

    .checkout-step {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        margin: 10px 0;

        &__icon {
            width: 64px;
            height: 64px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid $color-border;
            border-radius: 50%;
            color: $color-text-secondary-2;
            transition: all .3s;

            & svg {
                width: 24px;
                height: 24px;
                fill: currentColor;
            }
        }

        &.is-active &__icon {
            background-color: $color-primary;
            color: #fff;
            border-color: transparent;
        }

        &__info {
            padding-left: 24px;
            width: calc(100% - 64px);
        }

        &__name {
            color: $color-text-secondary;
            font-size: 12px / 14px;
        }

        &__title {
            margin-top: 9px;
            font-size: 14px / 17px;
            color: $color-text-primary;
        }
    }
</style>
