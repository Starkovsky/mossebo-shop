<template>
    <div class="ui-block">
        <div>
            Доставка
        </div>

        <div>
            <button @click="prev" class="button button-light">
                Назад
            </button>
        </div>

        <div>
            <button @click="next" class="button button-primary">
                К выбору типа оплаты
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Shipping",
        methods: {
            prev() {
                this.$store.dispatch('checkout/prev')
            },

            next() {
                this.$store.dispatch('checkout/next')
            },
        }
    }
</script>

<style scoped>

</style>
