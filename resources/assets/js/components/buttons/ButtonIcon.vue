<template>
    <component
        :is="tag"
        @click="click"
        class="button button"
    >
        <svg v-if="position === 'left'" class="button__icon button__icon--left">
            <use :xlink:href="'/assets/images/icons.svg#' + icon"></use>
        </svg>

        <span class="button__content">
            <slot></slot>
        </span>

        <svg v-if="position === 'right'" class="button__icon button__icon--right">
            <use :xlink:href="'/assets/images/icons.svg#' + icon"></use>
        </svg>
    </component>
</template>

<script>
    export default {
        name: "ButtonIcon",

        props: {
            tag: {
                type: String,
                default: 'button'
            },

            icon: String,

            position: {
                type: String,
                default() {
                    return 'left'
                }
            }
        },

        methods: {
            click() {
                this.$emit('click')
            }
        }
    }
</script>
