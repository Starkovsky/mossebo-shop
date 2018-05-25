<template>
    <div class="checkout">
        <checkout-steps
            active="cart"
        ></checkout-steps>

        <div class="py-3"></div>

        <div v-if="true">
            <cart></cart>
        </div>
    </div>
</template>

<script>
    import Cart from "../cart/Cart"
    import CheckoutSteps from './CheckoutSteps'


    export default {
        name: "Checkout",

        components: {
            CheckoutSteps,
            Cart
        },
    }
</script>

<style scoped>

</style>
