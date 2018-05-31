<template>
    <div class="checkout-step">
        <h2 v-if="title" class="checkout-step__title">
            {{ title }}
        </h2>

        <div class="checkout-step__content">
            <slot></slot>
        </div>

        <div class="checkout-step__controls-wrap">
            <div class="checkout-step__controls">
                <div class="checkout-step__back">
                    <slot name="back"></slot>
                </div>

                <div class="checkout-step__forward">
                    <slot name="forward"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CheckoutStep",
        props: [
            'title'
        ]
    }
</script>
