<template>
    <div class="product-page__info">
        <div class="product-page__actions text-right">
            <product-actions :product-id="product.id"></product-actions>
        </div>

        <div class="product-page__prices">
            <div :class="'product-page__price' + (hasDiscount ? ' product-page__price--sale' : '')">
                <formatted-price
                    :value="productPrice"
                ></formatted-price>
            </div>

            <template v-if="hasDiscount">
                <div class="product-page__oldprice">
                    <formatted-price
                        :value="maxPrice"
                    ></formatted-price>
                </div>

                <div class="product-page__saving">
                    Вы сэкономите:
                    <formatted-price
                        :value="discountValue"
                    ></formatted-price>
                </div>
            </template>
        </div>

        <div v-if="product$.badges" class="product-page__badges">
            <badges
                :badges="product$.badges"
                :no-tooltips="true"
                :use-title-as-text="true"
            ></badges>
        </div>

        <div class="product-page__stars">
            <rating
                class-name-modificators="lg"
                :num="product$.rating ? product$.rating.num : undefined"
                :rate="product$.rating ? product$.rating.rate : undefined"
            ></rating>
        </div>

        <div class="product-page__params">
            <div class="row row--no-v">
                <div v-if="false" class="product-page__param">
                    <div class="product-param">
                        Артикул:
                        <span class="product-param__value">
                            {{ product$.id }}
                        </span>
                    </div>
                </div>

                <div class="product-page__param">
                    <div class="product-param">
                        Наличие:
                        <span class="product-param__value">
                            Под заказ
                        </span>
                    </div>
                </div>

                <div class="product-page__param">
                    <div class="product-param">
                        Срок поставки:
                        <span class="product-param__value">
                            14 дней
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-page__sizes">
            <div class="product-page-sizes">
                <span class="product-page-sizes__name">
                    Габариты:
                </span>

                <div class="product-page-sizes__list">
                    <div class="row row--no-padding">
                        <div class="col-4">
                            <div class="product-page-sizes__size">
                                <div class="product-size">
                                    <svg class="product-size__icon">
                                        <use xlink:href="/assets/images/icons.svg#symbol-width"></use>
                                    </svg>

                                    <span class="product-size__value">
                                        {{ product$.width / 10 }} см
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="product-page-sizes__size">
                                <div class="product-size">
                                    <svg class="product-size__icon">
                                        <use xlink:href="/assets/images/icons.svg#symbol-height"></use>
                                    </svg>

                                    <span class="product-size__value">
                                        {{ product$.height / 10 }} см
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="product-page-sizes__size">
                                <div class="product-size">
                                    <svg class="product-size__icon">
                                        <use xlink:href="/assets/images/icons.svg#symbol-length"></use>
                                    </svg>

                                    <span class="product-size__value">
                                        {{ product$.length / 10 }} см
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div v-if="false" class="col-6 col-sm-3 col-md-6 col-lg-3">
                            <div class="product-page__size">
                                <div class="product-size">
                                    <svg class="product-size__icon">
                                        <use xlink:href="/assets/images/icons.svg#symbol-weight"></use>
                                    </svg>

                                    <span class="product-size__value">
                                        {{ product$.weight / 1000 }} кг
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="selectable$.length" class="product-page__attributes">
            <div class="product-controls-attributes">
                <div class="row">
                    <template v-for="attribute in selectable$">
                        <div class="col-12 col-sm-6 col-lg-6">
                            <multi-select
                                v-model="attribute.value"
                                :options="attribute.options"
                                :max-height="300"
                                :placeholder="attribute.title"
                                :searchable="false"
                                :hide-selected="false"
                                :multiple="false"
                                :allow-empty="true"
                                @select="select(attribute)"
                                @remove="select(attribute)"
                                :class="{'has-error': attribute.error}"
                            >
                                <template slot="option" slot-scope="props">
                                    <div :class="'attribute-option attribute-option--' + props.option.id">
                                        {{ props.option.title }}
                                    </div>
                                </template>

                                <template slot="singleLabel" slot-scope="props">
                                    <div :class="'attribute-option attribute-option--' + props.option.id">
                                        {{ props.option.title }}
                                    </div>
                                </template>
                            </multi-select>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="product-page__buttons">
            <div class="product-page__fw">
                <div class="row row--half">
                    <div class="col-sm-12 col-md-5 col-lg-12 col-xl-5">
                        <a
                            href="#popup-one-click"
                            type="button"
                            class="product-page__button button button-long button-dark js-form-popup"
                        >
                            Купить в 1 клик
                        </a>
                    </div>

                    <div class="col-sm-12 col-md-7 col-lg-12 col-xl-7">
                        <template v-if="quantity === 0">
                            <button-loading
                                class="product-page__button button button-icon button-long button-primary js-add-to-cart-btn"
                                :loading="loading"
                                @click="addToCart"
                            >
                                <svg class="button__icon button__icon--left">
                                    <use xlink:href="/assets/images/icons.svg#symbol-cart-add"></use>
                                </svg>

                                <span class="button__content">
                                    Добавить в корзину
                                </span>

                                <div class="tt"></div>
                            </button-loading>
                        </template>

                        <template v-else>
                            <button-loading
                                tag="div"
                                class="product-page__button product-page__button--num button button-long button-primary"
                                :loading="loading"
                            >
                                <num-control
                                    :number="quantity"
                                    @update:number="setQty"
                                    :min="1"
                                    :max="99"
                                    :classNameModificators="['large', 'product']"
                                ></num-control>
                            </button-loading>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // todo: допилить подсветки красиво

    import { mapState } from 'vuex'
    import MultiSelect from 'vue-multiselect'
    import Core from '../../../scripts/core'
    import ProductActions from './ProductActions'
    import NumControl from '../../NumControl'
    import ButtonLoading from '../../buttons/ButtonLoading'
    import { makeKey } from '../../../scripts/shop/Cart'
    import ProductSaleExtendedMixin from '../../../mixins/ProductSaleExtended'
    import FormattedPrice from '../price/FormattedPrice'
    import Rating from '../../Rating'
    import Badges from '../badges/Badges'
    import ProductViewsHandler from '../../../scripts/shop/ProductViewsHandler'

    export default {
        name: "ProductControls",

        mixins: [
            ProductSaleExtendedMixin
        ],

        components: {
            MultiSelect,
            NumControl,
            ButtonLoading,
            ProductActions,
            FormattedPrice,
            Rating,
            Badges
        },

        props: {
            selectable: {
                type: Array,
                default() {
                    return []
                }
            }
        },

        data() {
            return {
                options: [],
                canAdd$: false,
                canShowError: false,
                selectable$: [
                    ... this.selectable
                ]
            }
        },

        mounted() {
            if (this.product) {
                ProductViewsHandler.set(this.product.id)
            }
        },

        watch: {
            options: function() {
                this.canAdd()
            },

            canAdd$: function(newValue, oldValue) {
                if (newValue === true && oldValue === false && this.selectable$.length) {
                    this.touchButton()
                }
            }
        },

        methods: {
            select(attribute) {
                attribute.error = false

                this.$nextTick(() => {
                    this.collectOptions()
                })
            },

            collectOptions() {
                this.options = this.selectable$.reduce((acc, item) => {
                    if (item.value && item.options.find(option => option.id === item.value.id)) {
                        acc.push(item.value.id)
                    }

                    return acc
                }, [])
            },

            canAdd() {
                let canAdd = true

                this.selectable$ = this.selectable$.map(attribute => {
                    if (this.attributeHasError(attribute)) {
                        canAdd = false

                        if (this.canShowError) {
                            attribute.error = true
                        }
                    }

                    return attribute
                })

                return this.canAdd$ = canAdd
            },

            addToCart() {
                this.canShowError = true

                if (this.canAdd()) {
                    this.$store.dispatch('cart/addProduct', [{id: this.product$.id, options: this.options}, 1])
                        .then(() => Core.metrika.reachGoal('add-to-cart'))
                }
            },

            attributeHasError(attribute) {
                if (! attribute.need_to_select) return false

                return ! (attribute.value && this.options.indexOf(attribute.value.id) !== -1)
            },

            setQty(qty) {
                this.$store.dispatch('cart/updateProduct', [{id: this.product$.id, options: this.options}, qty])
            },

            initSocials() {
                if (window.uSocial) {
                    window.uSocial.init()
                }
            },

            touchButton() {
                let btnEl = this.$el.querySelector('.js-add-to-cart-btn')

                if (! btnEl) return

                btnEl.classList.remove('button-accent')

                this.$nextTick(() => {
                    btnEl.classList.add('button-accent')
                })
            }
        },

        computed: {
            key() {
                return makeKey(this.product$.id, this.options)
            },

            hasDiscount() {
                return this.maxPrice && this.maxPrice !== this.productPrice
            },

            ... mapState({
                quantity(state) {
                    let item = state.cart.cart.getItemByKey(this.key)

                    if (item) {
                        return item.getQuantity()
                    }

                    return 0
                },

                loading(state) {
                    return state.cart.loading
                }
            })
        }
    }
</script>
