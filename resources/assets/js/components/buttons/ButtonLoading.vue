<template>
    <component
        :is="tag"
        @click="click"
        :class="{'button-loading': true, 'is-loading': loading}"
    >
        <div class="button-loading__content">
            <slot></slot>
        </div>

        <svg class="button-loading__loader">
            <use xlink:href="/assets/images/icons.svg#symbol-spinner"></use>
        </svg>
    </component>
</template>

<script>
    export default {
        name: "ButtonLoading",

        props: {
            tag: {
                type: String,
                default: 'button'
            },

            loading: Boolean
        },

        methods: {
            click() {
                this.$emit('click')
            }
        }
    }
</script>
