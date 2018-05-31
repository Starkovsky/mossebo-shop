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
            active: 'activate'
        },

        mounted() {
            this.activate()
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

            activate() {
                this.$nextTick(() => {
                    let activeEl = this.getActiveEl()
                    let lineEl = this.getLineEl()

                    lineEl.style.left = Math.round(activeEl.offsetLeft) + 'px'
                    lineEl.style.width = Math.round(activeEl.scrollWidth) + 'px'
                })
            },

            isActive(key) {
                return this.active === key
            }
        }
    }
</script>
