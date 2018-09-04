<template>
    <div class="reviews-list">
        <div class="reviews-list__slider js-slider">
            <template v-for="review in reviews$">
                <review-item
                    :key="'review-' + review.id"
                    :review="review"
                    @edit="edit(review)"
                    @delete="remove(review)"
                ></review-item>
            </template>
        </div>

        <div v-show="sliderInited" class="reviews-list__prev">
            <button type="button" class="slick-prev slick-arrow slick-arrow--small js-slider-prev">
                <svg class="symbol-icon symbol-arrow-forward">
                    <use xlink:href="/assets/images/icons.svg#symbol-arrow-back"></use>
                </svg>
            </button>
        </div>

        <div v-show="sliderInited" class="reviews-list__next">
            <button type="button" class="slick-next slick-arrow slick-arrow--small js-slider-next">
                <svg class="symbol-icon symbol-arrow-forward">
                    <use xlink:href="/assets/images/icons.svg#symbol-arrow-forward"></use>
                </svg>
            </button>
        </div>

        <template v-if="sliderInited">
            <div class="reviews-list__pagination">
                {{ currentSlide }} из {{ reviews.length }}
            </div>
        </template>

        <template v-else>
            <button
                v-if="moreBtnIsVisible"
                class="catalog-more-btn block-ui js-more-btn"
                @click="showAll"
            >
                {{ $root.translate('Show all') }}
            </button>
        </template>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import ReviewItem from './ReviewItem'
    import Rating from '../Rating'
    import MobileSliderMixin from '../../mixins/MobileSliderMixin'

    export default {
        name: 'ReviewsList',

        mixins: [
            MobileSliderMixin
        ],

        components: {
            ReviewItem,
            Rating,
        },

        props: [
            'url',
            'title',
            'hideButton'
        ],

        data() {
            return {
                all: false,
                currentSlide: 1
            }
        },

        watch: {
            sliderInited: 'handleSliderStateChange'
        },

        mounted() {
            this.makeSlider()
        },

        methods: {
            retry() {
                this.$store.dispatch('reviews/list/reFetch')
            },

            showAll() {
                this.all = true
            },

            edit(review) {
                this.$emit('edit', review)
            },

            remove(review) {
                this.$store.dispatch('reviews/removeReview', review)
            },

            needsToDestroySlider() {
                return this.$root.windowMoreThan('md')
            },

            getSliderSettings() {
                console.log(this.sliderEl$.find('.js-slider-next'))
                return {
                    infinite: true,
                    speed: 300,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    nextArrow: this.$el.querySelector('.js-slider-next'),
                    prevArrow: this.$el.querySelector('.js-slider-prev'),
                    variableWidth: false,
                    adaptiveHeight: true
                }
            },

            handleSliderStateChange() {
                if (this.sliderInited) {
                    this.currentSlide = this.sliderEl$.slick('slickCurrentSlide') + 1

                    this.sliderEl$.on('afterChange', this.setCurrentSlideNum)
                }
                else {
                    this.sliderEl$.off('afterChange', this.setCurrentSlideNum)
                }
            },

            setCurrentSlideNum(e, slick, slide) {
                this.currentSlide = slide + 1
            }
        },

        computed: {
            ... mapState({
                reviews: state => state.reviews.list.reviews,

            }),

            reviews$() {
                if (this.$root.windowMoreThan('md') && ! this.all) {
                    return this.reviews.slice(0, 3)
                }

                return this.reviews
            },

            moreBtnIsVisible() {
                return this.reviews$.length !== this.reviews.length
            },
        }
    }
</script>
