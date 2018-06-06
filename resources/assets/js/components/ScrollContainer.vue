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
            this.check()

            this.observer = new MutationObserver(this.check.bind(this))

            this.observer.observe(
                this.$el,
                { attributes: false, childList: true, characterData: true, subtree: true }
            )
        },

        beforeDestroy() {
            this.unbindEvents()
            this.observer.disconnect()
        },

        methods: {
            check() {
                if (this.$el.scrollHeight > this.maxHeight) {
                    this.handleScroll()
                    this.bindEvents()
                }
                else {
                    this.$el.classList.remove('overflow-top')
                    this.$el.classList.remove('overflow-bottom')
                    this.$el.classList.remove('overflow-both')
                    this.unbindEvents()
                }
            },

            bindEvents() {
                if (_.isFunction(this.unbinder)) {
                    return
                }

                let scrollHandler = _.throttle(() => {
                    this.handleScroll()
                }, 64, { leading: false })

                this.unbinder = () => {
                    this.$el.removeEventListener('scroll', scrollHandler)
                    this.unbinder = null
                    scrollHandler = null
                }

                this.$el.addEventListener('scroll', scrollHandler, { passive: true })
            },

            unbindEvents() {
                if (_.isFunction(this.unbinder)) {
                    this.unbinder()
                }
            },

            handleScroll() {
                let el = this.$el

                let overflowTop = el.scrollTop !== 0
                let overflowBottom = el.offsetHeight + el.scrollTop !== el.scrollHeight

                if (overflowTop && overflowBottom) {
                    if (!el.classList.contains('overflow-both')) {
                        el.classList.remove('overflow-top')
                        el.classList.remove('overflow-bottom')
                        el.classList.add('overflow-both')
                    }
                }
                else {
                    if (el.classList.contains('overflow-both')) {
                        el.classList.remove('overflow-both')
                    }

                    if (overflowTop) {
                        if (! el.classList.contains('overflow-top')) {
                            el.classList.add('overflow-top')
                        }
                    }
                    else {
                        if (! el.classList.contains('overflow-top')) {
                            el.classList.add('overflow-top')
                        }
                    }

                    if (overflowBottom) {
                        if (! el.classList.contains('overflow-bottom')) {
                            el.classList.add('overflow-bottom')
                        }
                    }
                    else {
                        if (el.classList.contains('overflow-bottom')) {
                            el.classList.remove('overflow-bottom')
                        }
                    }
                }
            }
        }
    }
</script>
