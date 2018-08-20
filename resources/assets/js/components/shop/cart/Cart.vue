<template>
    <!--<transition-group-->
        <!--name="fade-up"-->
        <!--mode="out-in"-->
        <!--@before-enter="beforeEnter"-->
        <!--@before-leave="beforeEnter"-->
        <!--@after-leave="afterLeave"-->
        <!--class="cart-animation-wrap js-cart-wrap"-->
        <!--tag="div"-->
    <!--&gt;-->
        <div v-if="hasError" key="error" class="cart-animation-wrap__item">
            <div :class="{'cart-error': true, 'block-ui': !$root.isDesktop}">
                <h4>Ошибка соединения с сервером</h4>

                <div class="cart-error__buttons">
                    <button class="button button-primary" @click="refresh">
                        Попробовать еще раз
                    </button>
                </div>
            </div>
        </div>

        <div v-else-if="!isReady || (isEmpty && loading)" key="ready" class="cart-animation-wrap__item">
            <loading
                :loading="true"
                :no-overlay="true"
                :class="{'block-ui': !$root.isDesktop}"
            ></loading>
        </div>

        <div v-else-if="isEmpty" key="empty" class="cart-animation-wrap__item">
            <div :class="{'cart-empty-page text-center': true, 'block-ui': !$root.isDesktop}">
                Корзина пуста.

                <div class="cart-empty-page__button mt-32">
                    <a :href="$root.catalogUrl" class="button button-primary">
                        {{ $root.translate('Shop now') }}
                    </a>
                </div>
            </div>
        </div>

        <div v-else key="list" class="cart-animation-wrap__item">
            <loading :loading="loading$" key="list">
                <div class="cart-page">
                    <div :class="{'block-ui': $root.windowBetween('md', 'lg')}">
                        <cart-table></cart-table>
                    </div>

                    <template v-if="$root.isDesktop">
                        <div class="cart-page__summary">
                            <div class="cart-summary">
                                <div class="cart-summary__promo">
                                    <promo-form></promo-form>
                                </div>

                                <div class="cart-summary__total">
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
                    </template>
                </div>
            </loading>
        </div>

    <!--</transition-group>-->
</template>

<script>
    import PromoForm from './PromoForm'
    import Mixin from './mixin'

    export default {
        name: "Cart",

        components: {
            PromoForm
        },

        mixins: [
            Mixin
        ],

        mounted() {
            this.$store.dispatch('cart/init')
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
        },
    }
</script>
