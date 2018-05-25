<template>
    <span>{{ tweeningValue }}</span>
</template>

<script>
    export default {
        props: {
            value: {
                type: Number,
                required: true
            },
            duration: {
                type: Number,
                default: 500
            }
        },

        data() {
            return {
                tweeningValue: 0
            }
        },

        watch: {
            value(newValue, oldValue) {
                this.tween(oldValue, newValue)
            }
        },

        mounted() {
            this.tweeningValue = this.value
        },

        methods: {
            tween(startValue, endValue) {
                let perMS = (endValue - startValue) / this.duration

                let timeElapsed = (() => {
                    let startTime = performance.now()

                    return () => performance.now() - startTime > this.duration
                })()

                let animate = () => {
                    if (timeElapsed()) {
                        this.tweeningValue = this.value
                    }
                    else {
                        this.tweeningValue = (parseFloat(this.tweeningValue) + perMS).toFixed(0)

                        requestAnimationFrame(animate)
                    }
                }

                animate()
            }
        }
    }
</script>
