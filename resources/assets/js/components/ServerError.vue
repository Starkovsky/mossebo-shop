<template>
    <div v-if="error" class="server-error">
        <h4 class="server-error__title title-h4">
            {{ $root.translate('Server connection error') }}
        </h4>

        <div class="server-error__button">
            <button @click="click" type="button" class="button button-primary">
                {{ $root.translate('Try again') }}
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ServerError',

        props: [
            'error'
        ],

        methods: {
            click() {
                this.$emit('retry')
            }
        }
    }
</script>
