<template>
    <transition-group
        name="fade-up"
        mode="out-in"
        @before-enter="beforeEnter"
        @before-leave="beforeEnter"
        @after-leave="afterLeave"
        class="cart-animation-wrap js-cart-wrap"
        tag="div"
    >
        <div v-if="hasError" key="error" class="cart-animation-wrap__item">
            <div class="cart-error block-ui">
                <h4>Ошибка соединения с сервером</h4>

                <div class="cart-error__buttons">
                    <button class="button button-primary" @click="refresh">
                        Попробовать еще раз
                    </button>
                </div>
            </div>
        </div>

        <div v-else-if="!isReady" key="ready" class="cart-animation-wrap__item">
            <loading
                class="block-ui"
                :loading="true"
                :no-overlay="true"
            ></loading>
        </div>

        <div v-else-if="isEmpty" key="empty" class="cart-animation-wrap__item">
            <div class="cart-empty block-ui">
                Корзина пуста.
            </div>
        </div>

        <div v-else key="list" class="cart-animation-wrap__item">
            <loading :loading="loading$" key="list">
                <div :class="{'cart-page': true, 'block-ui': isDesktop}">
                    <cart-table
                        :products.sync="products"
                    ></cart-table>

                    <template v-if="isDesktop">
                        <div class="cart-page__total">
                            <div class="cart-total">
                    <span class="cart-total__label">
                        Предварительная цена:
                    </span>

                                <span class="cart-total__value">
                        <formatted-price
                            :value="totalPrice"
                        ></formatted-price>
                    </span>
                            </div>
                        </div>

                        <div class="cart-page__controls">
                            <div class="cart-page__back">
                                <a class="button button-light" href="/">
                                    <svg class="button__icon button__icon--left">
                                        <use xlink:href="/assets/images/icons.svg#symbol-arrow-back"></use>
                                    </svg>

                                    К покупкам
                                </a>
                            </div>

                            <div class="cart-page__submit">
                                <button @click="next" class="button button-primary">
                                    Оформить заказ

                                    <svg class="button__icon button__icon--right">
                                        <use xlink:href="/assets/images/icons.svg#symbol-arrow-forward"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>

                    <template v-else>
                        <h4 class="cart-page__mobile-total-title">
                            Итого
                        </h4>

                        <div class="cart-page__mobile-total cart-total-mobile block-ui">
                            <table>
                                <tbody>
                                <tr>
                                    <td>
                                        Товаров:
                                    </td>

                                    <td>
                                        {{ productsQuantity }}
                                    </td>

                                    <td>
                                        <formatted-price
                                            :value="productsPrice"
                                        ></formatted-price>
                                    </td>
                                </tr>

                                <tr v-if="false">
                                    <td>
                                        Доставка:
                                    </td>

                                    <td>

                                    </td>

                                    <td>
                                        <formatted-price
                                            :value="shippingPrice"
                                        ></formatted-price>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        Всего:
                                    </td>

                                    <td>

                                    </td>

                                    <td>
                                        <formatted-price
                                            :value="totalPrice"
                                        ></formatted-price>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="cart-page__mobile-submit">
                            <button @click="next" class="button button-primary">
                                Оформить заказ

                                <svg class="button__icon button__icon--right">
                                    <use xlink:href="/assets/images/icons.svg#symbol-arrow-forward"></use>
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </loading>
        </div>

    </transition-group>
</template>

<script>
    import axios from 'axios'
    import Core from '../../../scripts/core'
    import CheckoutSteps from '../checkout/CheckoutSteps'
    import Mixin from './mixin'
    import AnimatedInteger from '../../../components/AnimatedInteger'

    export default {
        name: "Cart",

        components: {
            CheckoutSteps,
            AnimatedInteger
        },

        mixins: [
            Mixin
        ],

        mounted() {
            this.$store.dispatch('cart/init')
        },

        computed: {
            isDesktop() {
                return this.$root.windowMoreThan('md')
            },
        },

        methods: {
            getWrapEl() {
                return document.querySelector('.js-cart-wrap')
            },

            beforeEnter(el) {
                let wrapEl = this.getWrapEl()

                wrapEl.classList.add('animation-in-process')

                this.$nextTick(() => {
                    wrapEl.style.height = (el.clientHeight + 100) + 'px'
                })
            },

            afterLeave() {
                let wrapEl = this.getWrapEl()

                this.$nextTick(() => {
                    wrapEl.style.height = 'auto'
                    wrapEl.classList.remove('animation-in-process')
                })
            },

            next() {
                this.$store.dispatch('checkout/next')
            },
        },
    }
</script>


<style lang="scss" scoped>
    .cart-animation-wrap {
        padding: 50px 0;
        margin: -50px 0;
        overflow: hidden;
        transform: translate3d(0, 0, 0);
        transition: height .3s;
    }

    .cart-animation-wrap.animation-in-process {
        position: relative;

        & > .cart-animation-wrap__item {
            position: absolute;
            width: 100%;
        }
    }
</style>
