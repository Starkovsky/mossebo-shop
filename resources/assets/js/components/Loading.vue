<template>
    <div :class="{
        'loading-wrap': true,
        'loading-wrap--no-overlay': noOverlay,
        'loading-wrap--no-min-height': noMinHeight,
        'loading-wrap--sticky': sticky && loading,
        loaded: !loading,
    }">
        <div v-if="loading" class="loading-wrap__spinner">
            <loading-icon class="loading-wrap__icon"></loading-icon>
        </div>

        <div class="loading-wrap__content">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    import LoadingIcon from './LoadingIcon'

    export default {
        name: 'loading',

        components: {
            LoadingIcon
        },

        props: {
            loading: {
                type: Boolean,
                default: false
            },
            sticky: {
                type: Boolean,
                default: false
            },
            noOverlay: {
                type: Boolean,
                default: false
            },
            noMinHeight: {
                type: Boolean,
                default: false
            }
        },
    }
</script>
