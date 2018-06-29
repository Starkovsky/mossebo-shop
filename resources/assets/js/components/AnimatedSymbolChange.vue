<template>
    <div class="anim-symbol-change">
        <template v-for="(symbol, index) in value$">
            <transition-group
                name="anim-symbol-change__anim"
                tag="div"
                @enter="done"
                @leave="done"
            >
                <div class="anim-symbol-change__plug" :key="index">0</div>
                <div class="anim-symbol-change__symbol" :key="symbol + index">
                    {{ symbol }}
                </div>
            </transition-group>
        </template>
    </div>
</template>

<script>
    export default {
        name: "AnimatedSymbolChange",

        props: [
            'value'
        ],

        watch: {
            value: 'explode'
        },

        data() {
            return {
                value$: ''
            }
        },

        created() {
            this.explode()
        },

        methods: {
            explode() {
                this.value$ = this.value.toString().split('')
            },

            done(el, done) {
                el.addEventListener('transitionend', done, {passive: true, once:true})
            }
        }
    }
</script>
