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

                                <div class="cart-summary__center">
                                    <table class="cart-intermediate">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span class="cart-intermediate__label">
                                                        {{ amountLabel }}:
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="cart-intermediate__value">
                                                        <formatted-price
                                                            :value="amount"
                                                        ></formatted-price>
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr v-if="promoAccepted && promoDiscount">
                                                <td>
                                                    <span class="cart-intermediate__label">
                                                        Скидка по промокоду:
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="cart-intermediate__value cart-intermediate__value--green">
                                                        <formatted-price
                                                            :value="promoDiscount"
                                                        ></formatted-price>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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

                            <div v-if="promoExist" class="cart-page__promo-info">
                                <promo-info
                                    :accepted="promoAccepted"
                                    :title="promoTitle"
                                    :description="promoDescription"
                                ></promo-info>
                            </div>

                            <div class="cart-page__promo-links">
                                <promo-links></promo-links>
                            </div>
                        </div>
                    </template>

                    <template v-else>
                        <div class="cart-page__mobile-promo mt-16">
                            <div class="cart-mobile-promo block-ui">
                                <div class="cart-mobile-promo__top">
                                    <div class="cart-mobile-promo__form">
                                        <promo-form></promo-form>
                                    </div>

                                    <div v-if="promoExist" class="cart-mobile-promo__info mt-24">
                                        <promo-info
                                            :accepted="promoAccepted"
                                            :title="promoTitle"
                                            :description="promoDescription"
                                        ></promo-info>
                                    </div>
                                </div>

                                <div class="cart-mobile-promo__bottom">
                                    <promo-links></promo-links>
                                </div>
                            </div>
                        </div>

                        <h4 class="cart-page__mobile-total-title">
                            Итого
                        </h4>

                        <div class="cart-page__mobile-total cart-total-mobile block-ui">
                            <div class="cart-total-mobile__top">
                                <table class="cart-intermediate">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <span class="cart-intermediate__label">
                                                {{ amountLabel }}:
                                            </span>
                                        </td>

                                        <td>
                                            <span class="cart-intermediate__value">
                                                <formatted-price
                                                    :value="amount"
                                                ></formatted-price>
                                            </span>
                                        </td>
                                    </tr>

                                    <tr v-if="promoAccepted && promoDiscount">
                                        <td>
                                            <span class="cart-intermediate__label">
                                                Скидка по промокоду:
                                            </span>
                                        </td>

                                        <td>
                                            <span class="cart-intermediate__value cart-intermediate__value--green">
                                                <formatted-price
                                                    :value="promoDiscount"
                                                ></formatted-price>
                                            </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="cart-total-mobile__bottom">
                                <div class="cart-total-mobile__label">
                                    Итого к оплате:
                                </div>

                                <div class="cart-total-mobile__total">
                                    <formatted-price
                                        :value="totalPrice"
                                    ></formatted-price>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </loading>
        </div>

    <!--</transition-group>-->
</template>

<script>
    import { mapGetters, mapState } from 'vuex'
    import PromoForm from './promo/PromoForm'
    import PromoLinks from './promo/PromoLinks'
    import PromoInfo from './promo/PromoInfo'
    import Mixin from './mixin'

    export default {
        name: "Cart",

        components: {
            PromoForm,
            PromoLinks,
            PromoInfo
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

        computed: {
            amountLabel() {
                return this.productsQuantity + ' ' + declOfNum(this.productsQuantity, ['товар', 'товара', 'товаров']) + ' на сумму'
            },

            ... mapGetters({
                promoExist: 'cart/promo/exist',
                promoAccepted: 'cart/promo/accepted',
            }),

            ... mapState({
                promoTitle: state => state.cart.promo.title,
                promoDescription: state => state.cart.promo.description,
            })
        }
    }
</script>
