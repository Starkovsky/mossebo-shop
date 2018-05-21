<template>
    <div class="checkout-steps bulge">
        <div class="checkout-steps__inner">
            <template v-for="step in steps">
                <div :key="step.identif" class="checkout-steps__item">
                    <div :class="{'checkout-step': true, active: isActive(step)}">
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
    export default {
        name: "CheckoutSteps",

        props: {
            active: String
        },

        data() {
            return {
                steps: [
                    {
                        identif: 'cart',
                        icon: 'symbol-cart',
                        stepName: 'Шаг первый',
                        title: 'Корзина',
                    },

                    {
                        identif: 'shipping',
                        icon: 'symbol-truck',
                        stepName: 'Шаг второй',
                        title: 'Доставка',
                    },

                    {
                        identif: 'payment',
                        icon: 'symbol-credit-card',
                        stepName: 'Шаг третий',
                        title: 'Оплата',
                    },

                    {
                        identif: 'confirmation',
                        icon: 'symbol-confirmation',
                        stepName: 'Шаг четвёртый',
                        title: 'Подтверждение',
                    },
                ]
            }
        },

        methods: {
            isActive(step) {
                return step.identif === this.active
            }
        }

    }
</script>

<style scoped>

</style>


