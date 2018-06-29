<template>
    <div class="scroll-container" :style="{'max-height': maxHeight + 'px'}">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: "ScrollContainer",

        props: {
            maxHeight: {
                type: Number,
                default: 200,
            }
        },

        mounted() {
            this.unbinders = []
            this.check()

            this.observer = new MutationObserver(this.check.bind(this))

            this.observer.observe(
                this.$el,
                { attributes: false, childList: true, characterData: true, subtree: true }
            )

            let resizeHadler = _.debounce(() => {
                this.check()
            }, 64)

            this.resizeUnsubscriber = () => {
                window.removeEventListener('resize', resizeHadler)
            }

            window.addEventListener('resize', resizeHadler, {passive: true})
        },

        beforeDestroy() {
            if (_.isFunction(this.resizeUnsubscriber)) {
                this.resizeUnsubscriber()
                this.resizeUnsubscriber = null
            }

            if (_.isFunction(this.scrollUnsubscriber)) {
                this.scrollUnsubscriber()
                this.scrollUnsubscriber = null
            }

            this.unbindEvents()
            this.observer.disconnect()
        },

        methods: {
            check() {
                if (this.$el.scrollHeight > this.$el.clientHeight) {
                    this.handleScroll()
                    this.bindEvents()
                }
                else {
                    this.$el.removeAttribute('style')
                    this.$el.classList.remove('overflow-top')
                    this.$el.classList.remove('overflow-bottom')
                    this.$el.classList.remove('overflow-both')
                    this.unbindEvents()
                }
            },

            bindEvents() {
                let scrollHandler = _.throttle(() => {
                    this.handleScroll()
                }, 64, { leading: false })

                this.scrollUnsubscriber = () => {
                    this.$el.removeEventListener('scroll', scrollHandler)
                    scrollHandler = null
                }

                this.$el.addEventListener('scroll', scrollHandler, { passive: true })
            },

            unbindEvents() {
                if (_.isFunction(this.scrollUnsubscriber)) {
                    this.scrollUnsubscriber()
                    this.scrollUnsubscriber = null
                }
            },

            handleScroll() {
                let el = this.$el

                let overflowTop = el.scrollTop !== 0
                let overflowBottom = el.offsetHeight + el.scrollTop !== el.scrollHeight

                if (overflowTop && overflowBottom) {
                    el.classList.remove('overflow-top')
                    el.classList.remove('overflow-bottom')
                    el.classList.add('overflow-both')
                }
                else {
                    if (el.classList.contains('overflow-both')) {
                        el.classList.remove('overflow-both')
                    }

                    if (overflowTop) {
                        el.classList.add('overflow-top')
                    }
                    else {
                        el.classList.remove('overflow-top')
                    }

                    if (overflowBottom) {
                        el.classList.add('overflow-bottom')
                    }
                    else {
                        el.classList.remove('overflow-bottom')
                    }
                }
            }
        }
    }
</script>
