<template>
    <div>
        <a class="cart-btn js-cart-btn" href="javascript:void(0)">
            <div class="d-flex flex-nowrap align-items-center">
                <div class="cart-btn-icon">
                    <div class="badge js-badge">
                        {{ productsShortQuantity }}
                    </div>

                    <svg class="symbol-icon symbol-cart">
                        <use xlink:href="/assets/images/icons.svg#symbol-cart"></use>
                    </svg>
                </div>

                <div>
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

        <div class="dropdown-menu dropdown-menu--ht dropdown-menu-right ht-container" v-show="productsQuantity > 0">
            <div class="ht-inner">
                <div :class="{'cart-popup-wrap': !(isReady && isEmpty)}">
                    <transition name="fade" mode="out-in">
                        <div v-if="hasError" class="cart-error bulge">
                            <h4>Ошибка соединения с сервером</h4>

                            <div class="cart-error__buttons">
                                <button class="button button-primary" @click="refresh">
                                    Попробовать еще раз
                                </button>
                            </div>
                        </div>

                        <loading
                            v-else-if="!isReady"
                            class="bulge"
                            :loading="true"
                            :no-overlay="true"
                        ></loading>

                        <div v-else-if="isEmpty" class="cart-empty">
                            Корзина пуста.
                        </div>

                        <loading v-else :loading="loading" key="list" :no-min-height="true">
                            <div class="cart-popup bulge">
                                <div class="cart-popup__products">
                                    <cart-table
                                        :products.sync="products"
                                        :no-header="true"
                                        :small="true"
                                        class-name-modificators="small"
                                    ></cart-table>
                                </div>

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

    import Mixin from './mixin'

    export default {
        name: 'CartBtn',

        mixins: [
            Mixin
        ],

        watch: {
            productsQuantity: 'animateBadge'
        },

        mounted() {
            this.btn = this.$el.querySelector('.js-cart-btn')

            heightToggle(this.btn, {
                bindCloseEvents: true
            })

            let badgeEl = this.$el.querySelector('.js-badge')
            let debouncer = _.debounce(() => {
                badgeEl.classList.remove('bounce')
            }, 1000)


            this.badgeAnimator = _.throttle(() => {
                badgeEl.classList.add('bounce')
                debouncer()
            }, 1000, {leading: true});
        },

        beforeDestroy() {
            this.btn.heightToggle.destroy()
        },

        computed: {
            linkToCart() {
                return Core.siteUrl('/cart')
            },

            productsShortQuantity() {
                if (this.productsQuantity > 9) {
                    return '9+'
                }

                return this.productsQuantity
            }
        },

        methods: {
            animateBadge() {
                this.badgeAnimator()
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
