<template>
    <loading :loading="loading" :no-overlay="true">
        <template v-if="title && !loading">
            <h2 class="title-h2">
                {{ title }}
            </h2>
        </template>

        <div class="product-list" v-if="!loading">
            <div class="product-list__row row row--half js-slider">
                <template v-for="product in products">
                    <div
                        class="product-list__product col-lg-3"
                        :key="product.id"
                    >
                        <product-card-mother
                            :product="product"
                            :no-image-loading="true"
                            :types="['default', 'sale']"
                        ></product-card-mother>
                    </div>
                </template>
            </div>
        </div>
    </loading>
</template>

<script>
    import Loading from '../../Loading'
    import ProductCardMother from "./product-cards/ProductCardMother"
    import RequestMixin from '../../../mixins/RequestMixin'
    import MobileSliderMixin from '../../../mixins/MobileSliderMixin'
    import Product from '../../../scripts/shop/Product'

    export default {
        name: "ProductList",

        mixins: [
            RequestMixin,
            MobileSliderMixin
        ],

        components: {
            Loading,
            ProductCardMother,
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
                    this.products = products.slice(0, this.limit).map(product => new Product(product))

                    this.$nextTick(() => {
                        this.makeSlider()
                    })
                }
            },

            getSliderSettings() {
                return {
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
                }
            },
        },

        computed: {
            cardType() {
                return this.$root.windowMoreThan('lg') ? 'tile' : 'mobile'
            }
        },
    }
</script>
