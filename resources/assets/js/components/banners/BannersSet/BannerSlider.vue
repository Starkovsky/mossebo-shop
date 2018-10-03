<template>
    <div v-else class="banner-slider">
        <div v-show="sliderInited" class="banner-slider__prev">
            <button type="button" class="slick-prev slick-arrow slick-arrow--small js-slider-prev">
                <svg class="symbol-icon symbol-arrow-forward">
                    <use xlink:href="/assets/images/icons.svg#symbol-arrow-back"></use>
                </svg>
            </button>
        </div>

        <div class="banner-slider__slider js-slider">
            <div v-for="banner in banners" :key="banner.id" class="banner-slider__slide">
                <banner
                    :id="banner.id"

                    :link="banner.link"
                    :title="banner.title"
                    :caption="banner.caption"
                    :button-text="banner.button"

                    :title-color="banner.title_color"
                    :caption-color="banner.caption_color"
                    :button-color="banner.button_color"
                    :button-background="banner.button_background"

                    :image="banner.image"
                    :background-image1="banner.background_image_1"
                    :background-image2="banner.background_image_2"

                    :gradient-from="banner.gradient.color_from"
                    :gradient-to="banner.gradient.color_to"
                    :gradient-type="banner.gradient.type"
                    :gradient-angle="banner.gradient.angle"

                    @image-loaded="setCloneImage(banner)"
                ></banner>
            </div>
        </div>

        <div v-show="sliderInited" class="banner-slider__next">
            <button type="button" class="slick-next slick-arrow slick-arrow--small js-slider-next">
                <svg class="symbol-icon symbol-arrow-forward">
                    <use xlink:href="/assets/images/icons.svg#symbol-arrow-forward"></use>
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
    import MobileSliderMixin from '../../../mixins/MobileSliderMixin'
    import Mixin from './mixin'

    export default {
        name: 'banner-slider',

        mixins: [
            Mixin,
            MobileSliderMixin,
        ],

        props: {
            type: {
                type: String,
                default: 'single'
            }
        },

        created() {
            this.loadBanners()
                .then(() => {
                    let sliderEl = this.$el.querySelector('.js-slider')

                    this.sliderEl$ = $(sliderEl)

                    this.$nextTick(() => {
                        this.initSlider()

                        let swipeStart = sliderEl.slick.swipeStart

                        sliderEl.slick.swipeStart = function(event) {
                            sliderEl.classList.add('overflow')
                            swipeStart.call(sliderEl.slick, event)
                        }

                        this.sliderEl$.on('beforeChange', () => {
                            sliderEl.classList.add('overflow')
                        })

                        this.sliderEl$.on('afterChange', () => {
                            sliderEl.classList.remove('overflow')
                        })
                    })
                })
        },

        methods: {
            getSliderSettings() {
                let settings = {
                    dots: false,
                    infinite: false,
                    speed: 300,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    prevArrow: this.$el.querySelector('.js-slider-prev'),
                    nextArrow: this.$el.querySelector('.js-slider-next'),
                    variableWidth: false,
                    centerMode: false,
                    mobileFirst: true,
                }

                if (this.type === 'double') {
                    settings.responsive = [
                        {
                            breakpoint: this.$root.getBreakpoint('sm') - 1,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                            }
                        },
                    ]
                }

                return settings
            },

            setCloneImage(banner) {
                let clonedBanners = this.$el.querySelectorAll('.slick-cloned .banner--' + banner.id)

                if (clonedBanners.length) {
                    [].forEach.call(clonedBanners, el => {
                        let imageEl = el.querySelector('.banner__image')

                        imageEl.style.backgroundImage = 'url(' + banner.small_image + ')'

                        imageEl.classList.add('animate')
                        imageEl.classList.add('loaded')
                    })
                }
            }
        }
    }
</script>
