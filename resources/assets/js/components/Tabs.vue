<template>
    <div :class="classNameWithModificators('tabs')">
        <div
            v-for="(title, key) in tabs"
            :key="key"
            :class="{'tabs__item': true, 'is-active': isActive(key)}"
            @click="click(key)">
            {{ title }}
        </div>

        <div class="tabs__line-tube">
            <div class="tabs__line js-sort-line"></div>
        </div>
    </div>
</template>

<script>
    import ClassNameWithModificators from '../mixins/ClassNameWithModificators'

    export default {
        name: 'Tabs',

        mixins: [
            ClassNameWithModificators
        ],

        props: {
            active: String,
            tabs: Object
        },

        watch: {
            active: 'updateLinePosition'
        },

        mounted() {
            this.updateLinePosition()

            this.resizeUnsubscriber = this.$root.$on('resize', () => {
                this.updateLinePosition()
            })
        },

        beforeDestroy() {
            if (_.isFunction(this.resizeUnsubscriber)) {
                this.resizeUnsubscriber()
            }
        },

        methods: {
            getLineEl() {
                return this.$el.querySelector('.js-sort-line')
            },

            getActiveEl() {
                return this.$el.querySelector('.is-active')
            },

            click(key) {
                if (this.active !== key) {
                    this.$emit('activation', key)
                }
            },

            updateLinePosition() {
                this.$nextTick(() => {
                    let activeEl = this.getActiveEl()
                    let lineEl = this.getLineEl()

                    if (this.$root.windowLessThan('md')) {
                        this.updateLineV(activeEl, lineEl)
                    }
                    else {
                        this.updateLineH(activeEl, lineEl)
                    }
                })
            },

            updateLineH(activeEl, lineEl) {
                lineEl.setAttribute('style', `left:${Math.round(activeEl.offsetLeft)}px;width:${Math.round(activeEl.scrollWidth)}px`)
            },

            updateLineV(activeEl, lineEl) {
                lineEl.setAttribute('style', `top:${Math.round(activeEl.offsetTop)}px;height:${Math.round(activeEl.scrollHeight)}px`)
            },

            isActive(key) {
                return this.active === key
            }
        }
    }
</script>
