<template>
    <div class="payment-choose">
        <div class="row justify-content-center">
            <template v-for="(title, type) in payments">
                <div class="payment-choose__option col-12 col-md-6">
                    <input type="radio" name="payment" :id="`payment-${type}`" :checked="isActive(type)" style="display: none;">
                    <label class="huge-radio" :for="`payment-${type}`" @click="choose(type)">
                        {{ title }}
                    </label>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PaymentChoose",

        props: [
            'payments',
            'active'
        ],

        methods: {
            choose(type) {
                this.$emit('choose', type)
            },

            isActive(type) {
                return type === this.active
            }
        }
    }
</script>
