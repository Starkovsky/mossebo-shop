<template>
    <tabs
        :active="active$"
        :tabs="tabs"
        :class-name-modificators="classNameModificators"
        @activation="activate"
    ></tabs>
</template>

<script>
    import Tabs from './Tabs'

    export default {
        name: "TabsHtml",

        components: {
            Tabs,
        },

        props: {
            active: String,
            tabs: Object,
            classNameModificators: null
        },

        data() {
            return {
                active$: this.active || Object.keys(this.tabs)[0]
            }
        },

        mounted() {
            this.els = Object.keys(this.tabs).reduce((acc, query) => {
                acc[query] = document.querySelector(query)

                return acc
            }, {})
        },

        methods: {
            activate(key) {
                this.els[this.active$].addEventListener('transitionend', (e) => {
                    this.els[this.active$].classList.remove('active')

                    this.active$ = key

                    this.els[key].classList.add('active')

                    setTimeout(() => {
                        this.els[key].classList.add('show')
                    })
                }, {passive: true, once: true})

                this.els[this.active$].classList.remove('show')
            }
        }
    }
</script>
