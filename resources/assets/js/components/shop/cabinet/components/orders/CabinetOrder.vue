<template>
    <div class="cabinet-order">
        <div class="cabinet-order__panel js-order-ht">
            <div class="cabinet-order-panel">
                <div class="cabinet-order-panel__left">
                    <div class="cabinet-order-panel__num">
                        {{ $root.translate('Order №') }}&nbsp;{{ order.id }}
                    </div>

                    <div v-if="order.status" class="cabinet-order-panel__status">
                        <span class="cabinet-order-panel__status-label">
                            {{ $root.translate('Status') }}:
                        </span>

                        <span :style="{color: order.status.color || false}">
                            {{ order.status.name }}
                        </span>
                    </div>
                </div>

                <div class="cabinet-order-panel__right">
                    <div class="cabinet-order-panel__button">
                        <div class="cabinet-order-button">
                            <svg class="cabinet-order-button__icon">
                                <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cabinet-order__hidden ht-container">
            <div class="cabinet-order__inner ht-inner">
                <div class="cabinet-order__products">
                    <template v-if="$root.isDesktop">
                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th>Цена</th>
                                    <th>Количество</th>
                                    <th>Сумма</th>
                                </tr>
                            </thead>

                            <tbody>
                                <cabinet-order-product-row
                                    v-for="product in cart.getProducts()"
                                    :key="product.key"
                                    :product="product"
                                ></cabinet-order-product-row>
                            </tbody>
                        </table>
                    </template>

                    <template v-else>
                        <cabinet-order-product-item
                            v-for="product in cart.getProducts()"
                            :key="product.key"
                            :product="product"
                        ></cabinet-order-product-item>
                    </template>
                </div>

                <div class="cabinet-order__total">
                    <div class="cabinet-order__prices">
                        <div class="cabinet-order-prices">
                            <template v-if="cart.getPromoDiscount()">
                                <div class="cabinet-order-prices__total">
                                    <span class="cabinet-order-prices__label">
                                        {{ $root.translate('Promo discount') }}:
                                    </span>

                                    <span class="cabinet-order-prices__value">
                                        <formatted-price
                                            :value="cart.getPromoDiscount()"
                                        ></formatted-price>
                                    </span>
                                </div>
                            </template>

                            <div class="cabinet-order-prices__total">
                                <span class="cabinet-order-prices__label">
                                    {{ $root.translate('Total price') }}:
                                </span>

                                <span class="cabinet-order-prices__value">
                                    <formatted-price
                                        :value="cart.getTotal()"
                                    ></formatted-price>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cabinet-order__data">
                    <label-value-table
                        :data="data"
                    ></label-value-table>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import Cart, { makeKey } from '../../../../../scripts/shop/Cart'
    import PromoCode from '../../../../../scripts/shop/PromoCode'
    import FormattedPrice from '../../../price/FormattedPrice'
    import CabinetOrderProductRow from './CabinetOrderProductRow'
    import CabinetOrderProductItem from './CabinetOrderProductItem'
    import LabelValueTable from '../../../../LabelValueTable'

    export default {
        name: 'CabinetOrder',

        components: {
            FormattedPrice,
            CabinetOrderProductRow,
            CabinetOrderProductItem,
            LabelValueTable
        },

        props: [
            'order'
        ],

        data() {
            return {
                data: this.getOrderData(),
                cart: this.getCart()
            }
        },

        methods: {
            getCart() {
                let cart = new Cart()

                this.order.products.forEach(product => {
                    product.key = makeKey(
                        product.data.id,
                        product.data.options
                    )
                })

                cart.setProducts(this.order.products)

                if (this.order.promo) {
                    cart.setPromo(
                        new PromoCode(this.order.promo)
                    )
                }

                return cart
            },

            getOrderData() {
                return [
                    'first_name',
                    'last_name',
                    'phone',
                    'email',
                    'post_code',
                    'city',
                    'address',
                    'comment',
                ].reduce((acc, key) => {
                    if (key in this.order) {
                        let item = {
                            label: this.$root.translate('form.fields.' + key) + ':',
                            value: this.order[key]
                        }

                        if (key === 'comment') {
                            item.onEmpty = 'hide'
                            item.italic = true
                        }

                        acc.push(item)
                    }

                    return acc
                }, [])
            }
        },
    }

</script>
