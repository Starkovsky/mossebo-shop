<template>
    <div class="loading-wrap" v-bind:class="{'loaded': !loading}">
        <transition name="fade">
            <div v-if="loading" class="loading-wrap__spinner">
                <svg class="loading-wrap__icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
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
        </transition>

        <transition name="fade">
            <div class="loading-wrap__content">
                <slot></slot>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        name: 'loading',

        props: [
            'loading'
        ],
    }
</script>

<style lang="scss" scoped>

    @import "../../sass/variables/colors";

    .loading-wrap {
        position: relative;
        min-height: 200px;

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

        &:not(.without-overlay):not(.loaded) {
            &::before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(255, 255, 255, .5);
                z-index: 10;
            }
        }
    }
</style>
