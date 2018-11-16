<template>
    <div class="order-info">
        <div class="order-info__products">
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
                        <order-info-product-row
                            v-for="product in cart.getProducts()"
                            :key="product.key"
                            :product="product"
                        ></order-info-product-row>
                    </tbody>
                </table>
            </template>

            <template v-else>
                <order-info-product-item
                    v-for="product in cart.getProducts()"
                    :key="product.key"
                    :product="product"
                ></order-info-product-item>
            </template>
        </div>

        <div class="order-info__total">
            <div class="order-info__prices">
                <div class="order-info-prices">
                    <template v-if="cart.getPromoDiscount()">
                        <div class="order-info-prices__total">
                            <div class="order-info-prices__label">
                                {{ $root.translate('Promo discount') }}:
                            </div>

                            <div class="order-info-prices__value">
                                <formatted-price
                                    :value="cart.getPromoDiscount()"
                                ></formatted-price>
                            </div>
                        </div>
                    </template>

                    <div class="order-info-prices__total">
                        <span class="order-info-prices__label">
                            {{ $root.translate('Total price') }}:
                        </span>

                        <span class="order-info-prices__value">
                            <formatted-price
                                :value="cart.getTotal()"
                            ></formatted-price>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-info__data">
            <label-value-table
                :data="data"
            ></label-value-table>
        </div>
    </div>
</template>


<script>
    import Cart, { makeKey } from '../../../scripts/shop/Cart'
    import PromoCode from '../../../scripts/shop/PromoCode'
    import FormattedPrice from '../price/FormattedPrice'
    import OrderInfoProductRow from './OrderInfoProductRow'
    import OrderInfoProductItem from './OrderInfoProductItem'
    import LabelValueTable from '../../LabelValueTable'

    export default {
        name: 'OrderInfo',

        components: {
            FormattedPrice,
            OrderInfoProductRow,
            OrderInfoProductItem,
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
                    'street',
                    'house_number',
                    'apartment',
                    'floor',
                    'entrance',
                    'intercom',
                    'comment',
                ].reduce((acc, key) => {
                    if (key in this.order && !_.isNil(this.order[key])) {
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
