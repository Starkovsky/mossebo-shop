<template>
    <div class="confirmation-block">
        <div class="confirmation-block__head">
            <svg class="confirmation-block__icon">
                <use :xlink:href="'/assets/images/icons.svg#' + icon"></use>
            </svg>

            <div class="confirmation-block__title">
                {{ title }}
            </div>

            <div class="confirmation-block__change">
                <span @click="change" class="link link--dashed link--inverse">Изменить</span>
            </div>
        </div>

        <div class="confirmation-block__content">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ConfirmationBlock",

        props: [
            'icon',
            'title',
        ],

        methods: {
            change() {
                this.$emit('change')
            }
        }
    }
</script>
