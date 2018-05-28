<template>
    <div>
        <a class="cart-btn js-cart-btn" :href="btnLink">
            <div class="d-flex flex-nowrap align-items-center">
                <div class="cart-btn-icon">
                    <div class="badge js-badge" v-show="productsQuantity > 0">
                        {{ productsShortQuantity }}
                    </div>

                    <svg class="symbol-icon symbol-cart">
                        <use xlink:href="/assets/images/icons.svg#symbol-cart"></use>
                    </svg>
                </div>

                <div v-if="isDesktop">
                    <div class="cart-btn-name">
                        Корзина
                    </div>

                    <div v-if="productsQuantity > 0" class="cart-btn-result">
                        <!--<span class="items">-->
                            <!--{{ productsQuantity }}-->
                        <!--</span>-->

                        <!--шт. - -->

                        <span class="prices">
                            <formatted-price
                                :value="productsPrice"
                            ></formatted-price>
                        </span>
                    </div>
                </div>

                <svg class="symbol-icon symbol-keyboard-down">
                    <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
                </svg>
            </div>
        </a>

        <div class="dropdown-menu dropdown-menu-ht dropdown-menu-right ht-container" v-if="isDesktop">
            <div class="ht-inner">
                <div :class="{'cart-popup-wrap': !(isReady && isEmpty)}">
                    <transition name="fade" mode="out-in">
                        <div v-if="hasError" class="cart-error block-ui">
                            <h4>Ошибка соединения с сервером</h4>

                            <div class="cart-error__buttons">
                                <button class="button button-primary" @click="refresh">
                                    Попробовать еще раз
                                </button>
                            </div>
                        </div>

                        <loading
                            v-else-if="!isReady"
                            class="block-ui"
                            :loading="true"
                            :no-overlay="true"
                        ></loading>

                        <div v-else-if="isEmpty" class="cart-empty block-ui">
                            Корзина пуста.
                        </div>

                        <loading v-else :loading="loading$" key="list" :no-min-height="true">
                            <div class="cart-popup block-ui">
                                <scroll-container class="cart-popup__products" :max-height="260">
                                    <cart-table
                                        :products.sync="products"
                                        :no-header="true"
                                        :small="true"
                                        class-name-modificators="small"
                                    ></cart-table>
                                </scroll-container>

                                <div class="cart-popup__panel">
                                    <div class="cart-popup__total">
                                        <div class="cart-total">
                                            <span class="cart-total__label">
                                                Итого:
                                            </span>

                                            <span class="cart-total__value">
                                                <formatted-price
                                                    :value="productsPrice"
                                                ></formatted-price>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="cart-popup__submit">
                                        <a :href="linkToCart" class="button button-primary">
                                            Оформить заказ

                                            <svg class="button__icon button__icon--right">
                                                <use xlink:href="/assets/images/icons.svg#symbol-arrow-forward"></use>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </loading>

                    </transition>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Core from '../../../scripts/core'
    import PendingLoader from '../../../scripts/PendingLoader'

    import ScrollContainer from '../../ScrollContainer'

    import Mixin from './mixin'

    export default {
        name: 'CartBtn',

        mixins: [
            Mixin
        ],

        components: {
            ScrollContainer
        },

        data() {
            return {
                loaded: false
            }
        },

        watch: {
            isDesktop: 'checkHT'
        },

        mounted() {
            this.btn = this.$el.querySelector('.js-cart-btn')
            this.checkHT()

            let badgeEl = this.$el.querySelector('.js-badge')
            let debouncer = _.debounce(() => {
                badgeEl.classList.remove('bounce')
            }, 1000)


            this.badgeAnimator = _.throttle(() => {
                badgeEl.classList.add('bounce')
                debouncer()
            }, 1000, {leading: true});


            this.anumateUnsubscriber = this.$store.subscribe(mutation => {
                if (mutation.type === 'cart/CART_ADD_ITEM') {
                    if (this.loaded) {
                        this.$nextTick(() => {
                            this.badgeAnimator()
                        })
                    }
                    else if (this.$store.state.cart.ready) {
                        this.loaded = true
                    }
                }
            })
        },

        beforeDestroy() {
            if (this.btn.heightToggle) {
                this.btn.heightToggle.destroy()
            }

            if (typeof this.anumateUnsubscriber === 'function') {
                this.anumateUnsubscriber()
            }

            this.badgeAnimator = undefined
        },

        computed: {
            productsShortQuantity() {
                if (this.productsQuantity > 9) {
                    return '9+'
                }

                return this.productsQuantity
            },

            isDesktop() {
                return this.$root.windowMoreThan('lg')
            },

            btnLink() {
                if (this.isDesktop) {
                    return 'javascript:void(0)'
                }

                return this.linkToCart
            },

            linkToCart() {
                return Core.siteUrl('/cart')
            },
        },

        methods: {
            checkHT() {
                this.$nextTick(() => {
                    let htLoaded = !!this.btn.heightToggle

                    if (this.isDesktop && !htLoaded) {
                        heightToggle(this.btn, {
                            bindCloseEvents: true
                        })
                    }

                    if (!this.isDesktop && htLoaded) {
                        this.btn.heightToggle.destroy()
                    }
                })
            },
        }
    }
</script>
