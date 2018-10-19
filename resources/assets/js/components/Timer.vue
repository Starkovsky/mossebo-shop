<template>
    <div v-if="! isDone()" :class="classNameWithModificators('timer')">
        <div class="timer__container">
            <div v-if="days > 0" class="timer__num timer__num--days">
                <span>
                    <animated-symbol-change
                        :value="prepareNum(days)"
                    ></animated-symbol-change>
                </span>

                &thinsp;

                <span class="timer__label">
                    {{ $root.translate('days.short')}}
                </span>
            </div>

            <div class="timer__num timer__num--hours">
                <span>
                    <animated-symbol-change
                        :value="prepareNum(hours)"
                    ></animated-symbol-change>
                </span>

                &thinsp;

                <span class="timer__label">
                    {{ $root.translate('hours.short')}}
                </span>
            </div>

            <div class="timer__num timer__num--minutes">
                <span>
                    <animated-symbol-change
                        :value="prepareNum(minutes)"
                    ></animated-symbol-change>
                </span>

                &thinsp;

                <span class="timer__label">
                    {{ $root.translate('minutes.short')}}
                </span>
            </div>

            <div class="timer__num timer__num--seconds">
                <span>
                    <animated-symbol-change
                        :value="prepareNum(seconds)"
                    ></animated-symbol-change>
                </span>

                &thinsp;

                <span class="timer__label">
                    {{ $root.translate('seconds.short')}}
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    import AnimatedSymbolChange from './AnimatedSymbolChange'
    import ClassNameWithModificators from '../mixins/ClassNameWithModificators'
    import { parseTime } from '../scripts/core/time'

    export default {
        name: "Timer",

        mixins: [
            ClassNameWithModificators
        ],

        components: {
            AnimatedSymbolChange
        },

        props: {
            time: Number
        },

        watch: {
            time: function() {
                this.elapsed = 0
                this.start = new Date().getTime()
            }
        },

        data() {
            return {
                days: 0,
                hours: 0,
                minutes: 0,
                seconds: 0,
                stopped: false,
                start: null,
                elapsed: 0,
            }
        },

        mounted() {
            this.start = new Date().getTime()

            let animate = () => {
                let elapsed = (new Date().getTime() - this.start) / 1000

                if (elapsed - this.elapsed > 0.1) {
                    this.elapsed = elapsed
                    this.tick()
                }

                if (! (this.stopped || this.isDone())) {
                    requestAnimationFrame(animate)
                }
            }

            requestAnimationFrame(animate)
        },

        beforeDestroy() {
            this.stopped = true
        },

        methods: {
            isDone() {
                return this.timeLeft === 0
            },

            tick() {
                let result = parseTime(this.timeLeft)

                for (let i in result) {
                    this[i] = result[i]
                }

                this.$emit('tick', this.timeLeft)
            },

            prepareNum(num) {
                return num < 10 ? '0' + num : num
            }
        },

        computed: {
            timeLeft() {
                return Math.max(Math.round(this.time - this.elapsed), 0)
            }
        },
    }
</script>
