<template>
    <div class="button-group">
        <a :href="link" class="button-group__main">
            Подробнее
        </a>

        <div @click="sideClick" @mouseover="mouseOver" @mouseleave="mouseLeave" :class="{'button-group__side': true, 'is-hovered': sideIsHovered, 'is-active': sideIsActive}">
            <svg class="button-group__icon">
                <use :xlink:href="'/assets/images/icons.svg#' + icon"></use>
            </svg>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'product-card-button',

        props: [
            'link',
            'status'
        ],

        data() {
            return {
                sideIsHovered: false
            }
        },

        methods: {
            sideClick() {
                this.$emit('side-click')
            },

            mouseOver() {
                this.sideIsHovered = true
            },

            mouseLeave() {
                this.sideIsHovered = false
            }
        },

        computed: {
            sideIsActive() {
                return this.status === 'in-cart'
            },

            icon() {
                if (this.sideIsActive) {
                    return 'symbol-cart-success'
                }

                return this.sideIsHovered ? 'symbol-cart-add' : 'symbol-cart-empty'
            }
        }
    }
</script>
