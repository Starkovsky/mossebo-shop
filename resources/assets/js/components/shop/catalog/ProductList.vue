<template>
    <loading :loading="loading" :no-overlay="true">
        <template v-if="title && !loading">
            <h2 class="title-h2">
                {{ title }}
            </h2>
        </template>

        <div class="product-list" v-if="!loading">
            <div class="product-list__row row row--half js-products-slider">
                <template v-for="(product, index) in products">
                    <div
                        class="product-list__product col-lg-3"
                        :key="product.id"
                    >
                        <product-card
                            :product="product"
                            :no-image-loading="true"
                        ></product-card>
                    </div>
                </template>
            </div>
        </div>
    </loading>
</template>

<script>
    import axios from 'axios'
    import 'slick-carousel'

    import Loading from '../../Loading'
    import ProductCard from "./product-cards/ProductCard"
    import RequestMixin from '../../../mixins/RequestMixin'

    export default {
        name: "ProductList",

        mixins: [
            RequestMixin
        ],

        components: {
            Loading,
            ProductCard,
        },

        data () {
            return {
                products: [],
            }
        },

        props: {
            url: null,
            title: null,
            limit: {
                type: Number,
                default: 8
            },
        },

        mounted() {
            this.fetchProducts()
        },

        beforeDestroy() {
            this.$root.$off('resize', this.handleResize)
        },

        methods: {
            fetchProducts() {
                this.sendRequest('get', this.url)
                    .success(response => this.setProducts(response.data.products))
                    .silent()
            },

            setProducts(products = []) {
                if (products.length === 0) {
                    let containerEl = this.$el.closest('.js-product-list-container')

                    if (containerEl) {
                        containerEl.parentNode.removeChild(containerEl)
                    }
                }
                else {
                    this.products = products.slice(0, this.limit)

                    this.$nextTick(() => {
                        this.makeSlider()
                    })
                }
            },

            initSlider() {
                if (this.sliderInited) return

                let slider = this.$el.querySelector('.js-products-slider')

                if (! slider) return

                this.sliderEl$ = $(slider)

                this.sliderEl$.slick({
                    dots: true,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    nextArrow: false,
                    prevArrow: false,
                    variableWidth: true,
                    centerMode: true,
                    mobileFirst: true,

                    responsive: [
                        {
                            breakpoint: this.$root.getBreakpoint('sm') - 1,
                            settings: {
                                centerMode: false,
                            }
                        }
                    ]
                });

                this.sliderInited = true
            },

            destroySlider() {
                if (!this.sliderInited) return

                this.sliderEl$.slick('unslick')

                this.sliderInited = false
            },


            handleResize() {
                if (this.$root.windowMoreThan('lg')) {
                    this.destroySlider()
                }
                else {
                    this.initSlider()
                }
            },

            makeSlider() {
                this.$root.$on('resize', this.handleResize)

                this.$nextTick(() => {
                    this.handleResize()
                })
            },
        },

        computed: {
            cardType() {
                return this.$root.windowMoreThan('lg') ? 'tile' : 'mobile'
            }
        },
    }
</script>
