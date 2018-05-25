<template>
    <div :class="{
        'loading-wrap': true,
        'loading-wrap--no-overlay': noOverlay,
        'loading-wrap--no-min-height': noMinHeight,
        'loaded': !loading}"
    >
        <div v-if="loading" class="loading-wrap__spinner">
            <svg
                class="loading-wrap__icon"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 100 100"
                enable-background="new 0 0 0 0"
                xml:space="preserve"
            >
                <circle stroke="none" cx="12%" cy="50%" r="12%">
                    <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.1"/>
                </circle>

                <circle stroke="none" cx="50%" cy="50%" r="12%">
                    <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.2"/>
                </circle>

                <circle stroke="none" cx="88%" cy="50%" r="12%">
                    <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.3"/>
                </circle>
            </svg>
        </div>

        <div class="loading-wrap__content">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'loading',

        props: {
            loading: {
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

<style lang="scss" scoped>

    @import "../../sass/variables/colors";

    .loading-wrap {
        position: relative;

        &:not(.loaded) {
            min-height: 200px;
        }

        &--no-min-height {
            min-height: auto !important;
        }

        &__spinner {
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            width: 80px;
            height: 80px;
            margin: auto;
            z-index: 11;
        }

        &__icon {
            width: 100%;
            fill: $color-primary;
        }

        &:not(&--no-overlay)::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            background-color: #fff;
            z-index: -1;
            opacity: 0;
            transition: all .3s;
        }

        &:not(&--no-overlay):not(.loaded)::before {
            opacity: .5;
            z-index: 10;
            transition: opacity .3s;
        }
    }
</style>
