<template>
    <div class="catalog-sort">
        <div
            v-for="(title, type) in types"
            :key="type"
            :class="{'catalog-sort__item': true, active: isActive(type)}"
            @click="click(type)">
            {{ title }}
        </div>

        <div class="catalog-sort__line-tube">
            <div class="catalog-sort__line js-sort-line"></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'CatalogSort',

        props: {
            active: String,
            types: Object
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
                return this.$el.querySelector('.active')
            },

            click(type) {
                if (this.active !== type) {
                    this.$emit('change', type)
                }
            },

            activate() {
                this.$nextTick(() => {
                    let activeEl = this.getActiveEl()
                    let lineEl = this.getLineEl()

                    lineEl.style.left = activeEl.offsetLeft + 'px'
                    lineEl.style.width = activeEl.scrollWidth + 'px'
                })
            },

            isActive(type) {
                return this.active === type
            }
        }
    }
</script>
