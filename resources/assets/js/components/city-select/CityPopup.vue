<template>
    <div class="city-popup">
        <div class="city-popup__head">
            <div class="city-popup__title">
                {{ title }}
            </div>

            <div @click="close" class="city-popup__close">
                <svg class="city-popup__close-icon symbol-icon">
                    <use xlink:href="/assets/images/icons.svg#symbol-close"></use>
                </svg>
            </div>
        </div>

        <div class="city-popup__content">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'CityPopup',

        props: [
            'title',
        ],

        methods: {
            close() {
                this.$emit('close')
            }
        }
    }
</script>
