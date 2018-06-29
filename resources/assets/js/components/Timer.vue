<template>
    <div v-if="! isDone()" class="timer">
        <div class="timer__container">
            <div v-if="days > 0" class="timer__num timer__num--days">
                <span>
                    <animated-symbol-change
                        :value="prepareNum(days)"
                    ></animated-symbol-change>
                </span>

                {{ $root.translate('days.short')}}
            </div>

            <div class="timer__num timer__num--hours">
                <span>
                    <animated-symbol-change
                        :value="prepareNum(hours)"
                    ></animated-symbol-change>
                </span>

                {{ $root.translate('hours.short')}}
            </div>

            <div class="timer__num timer__num--minutes">
                <span>
                    <animated-symbol-change
                        :value="prepareNum(minutes)"
                    ></animated-symbol-change>
                </span>

                {{ $root.translate('minutes.short')}}
            </div>

            <div class="timer__num timer__num--seconds">
                <span>
                    <animated-symbol-change
                        :value="prepareNum(seconds)"
                    ></animated-symbol-change>
                </span>

                {{ $root.translate('seconds.short')}}
            </div>
        </div>
    </div>
</template>

<script>
    import AnimatedSymbolChange from './AnimatedSymbolChange'

    const second = 1
    const minute = second * 60
    const hour = minute * 60
    const day = hour * 24

    export default {
        name: "Timer",

        components: {
            AnimatedSymbolChange,
        },

        props: {
            time: Number
        },

        data() {
            return {
                elapsed: 0,
                days: 0,
                hours: 0,
                minutes: 0,
                seconds: 0,
                stopped: false
            }
        },

        mounted() {
            let start = performance.now();

            let animate = time => {
                this.elapsed = (time - start) / 1000

                this.tick()

                if (this.timeLeft > 0 && !this.stopped) {
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
                let left = this.timeLeft

                this.days = Math.floor(left / day)
                left -= day * this.days

                this.hours = Math.floor(left / hour)
                left -= hour * this.hours

                this.minutes = Math.floor(left / minute)

                this.seconds = Math.floor(left - minute * this.minutes)
            },

            prepareNum(num) {
                return num < 10 ? '0' + num : num
            }
        },

        computed: {
            timeLeft() {
                return Math.max(this.time - this.elapsed, 0)
            }
        },
    }
</script>
