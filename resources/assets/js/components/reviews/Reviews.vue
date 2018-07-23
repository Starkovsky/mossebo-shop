<template>
    <div class="reviews-pallete">
        <div class="reviews-pallete__wrap js-reviews-wrap">
            <div class="reviews-pallete__content">
                <!--<transition-->
                    <!--:name="animationName"-->
                    <!--@before-leave="beforeLeave"-->
                    <!--@enter="enter"-->
                    <!--@after-enter="afterEnter"-->
                <!--&gt;-->
                    <div
                        v-if="isActive('list')"
                        key="list"
                        class="reviews-pallete__item"
                    >
                        <reviews-list :url="url"></reviews-list>
                    </div>

                    <div
                        v-if="isActive('form')"
                        key="form"
                        class="reviews-pallete__item"
                    >
                        <review-form :url="url"></review-form>
                    </div>
                <!--</transition>-->
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    import ReviewForm from './ReviewForm'
    import ReviewsList from './ReviewsList'

    export default {
        name: 'Reviews',

        components: {
            ReviewForm,
            ReviewsList
        },

        props: [
            'url'
        ],

        mounted() {
            this.$store.dispatch('reviews/init')
        },

        methods: {
            isActive(step) {
                return this.activeStep === step
            },

            getWrapEl() {
                return this.$el.querySelector('.js-reviews-wrap')
            },

            beforeLeave(el) {
                let wrapEl = this.getWrapEl()
                wrapEl.classList.add('animation-in-process')

                this.$nextTick(() => {
                    wrapEl.style.height = el.clientHeight + 'px'
                })
            },

            enter(el) {
                let wrapEl = this.getWrapEl()

                this.$nextTick(() => {
                    wrapEl.style.height = el.clientHeight + 'px'
                })
            },

            afterEnter() {
                let wrapEl = this.getWrapEl()
                wrapEl.classList.remove('animation-in-process')

                this.$nextTick(() => {
                    wrapEl.style.height = 'auto'
                })
            },
        },

        computed: {
            ... mapState({
                steps: state => state.reviews.steps,
                animationName: state => 'slide-' + state.checkout.direction,
                activeStep: state => state.reviews.active
            }),
        }
    }
</script>
