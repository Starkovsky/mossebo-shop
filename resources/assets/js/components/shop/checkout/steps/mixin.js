import CheckoutStep from './CheckoutStep'

export default {
    components: {
        CheckoutStep
    },

    methods: {
        toStep(stepName) {
            this.$store.dispatch('checkout/set', stepName)
        },

        prevStep() {
            this.$store.dispatch('checkout/prev')
        },

        nextStep() {
            this.$store.dispatch('checkout/next')
        },
    }
}
