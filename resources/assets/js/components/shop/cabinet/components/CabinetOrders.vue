<template>
    <div class="cabinet-orders">
        <loading :loading="loading">
            <template v-if="! loading">
                <template v-if="orders.length === 0">
                    <div class="cabinet-orders__empty text-center">
                        {{ $root.translate('You have not made any orders yet.') }}

                        <div class="cabinet-orders__empty-btn mt-32">
                            <a :href="$root.catalogUrl" class="button button-primary">
                                {{ $root.translate('Shop now') }}
                            </a>
                        </div>
                    </div>
                </template>

                <template v-else>
                    <div class="cabinet-orders__list row">
                        <div v-for="order in orders" class="cabinet-orders__item col-12">
                            <div class="cabinet-order block-ui" :key="order.id">
                                <div class="cabinet-order__panel js-order-ht">
                                    <div class="cabinet-order__num">
                                        {{ $root.translate('Order №') }}&nbsp;{{ order.id }}
                                    </div>

                                    <div v-if="order.status" class="cabinet-order__status">
                                        <span class="cabinet-order__status-label">
                                            {{ $root.translate('Status') }}:
                                        </span>

                                        <span :style="{color: order.status.color || false}">
                                            {{ order.status.name }}
                                        </span>
                                    </div>

                                    <div class="cabinet-order__button">
                                        <div class="cabinet-order-button">
                                            <svg class="cabinet-order-button__icon">
                                                <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="cabinet-order__hidden ht-container">
                                    <div class="cabinet-order__inner ht-inner">
                                        <div class="cabinet-order__products">
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
                                                    <order-product-row
                                                        v-for="product in preparedProducts(order.products)"
                                                        :key="product.id"
                                                        :product="product"
                                                    ></order-product-row>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="cabinet-order__total">
                                            <div class="cabinet-order__prices">
                                                <div class="cabinet-order-prices">
                                                    <div class="cabinet-order-prices__total">
                                                        <span class="cabinet-order-prices__label">
                                                            {{ $root.translate('Total price') }}:
                                                        </span>

                                                        <span class="cabinet-order-prices__value">
                                                            <formatted-price
                                                                :value="orderTotal('defaultPrice', order)"
                                                            ></formatted-price>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="cabinet-order__data">
                                            <label-value-table
                                                class-name-modificators="long"
                                                :data="orderData(order)"
                                            ></label-value-table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </template>
        </loading>
    </div>
</template>

<script>

    // todo: оптимизировать? - формировать данные заказа только при открытии
    import Loading from '../../../Loading'
    import RequestMixin from '../../../../mixins/RequestMixin'
    import OrderProductRow from './orders/OrderProductRow'
    import FormattedPrice from '../../price/FormattedPrice'
    import DataHandler from '../../../../scripts/DataHandler'
    import LabelValueTable from '../../../LabelValueTable'

    export default {
        name: "CabinetOrders",

        components: {
            Loading,
            OrderProductRow,
            FormattedPrice,
            LabelValueTable
        },

        mixins: [
            RequestMixin
        ],

        data() {
            return {
                orders: [],
                options: []
            }
        },

        created() {
            this.fetch()
        },

        methods: {
            fetch() {
                this.loading = true

                DataHandler.get('attributes')
                    .then(({attributes}) => {
                        this.setOptions(attributes)
                        this.fetchOrders()
                    })
            },

            setOptions(attributes = []) {
                this.options = attributes.reduce((acc, attribute) => {
                    attribute.options.forEach(option => {
                        acc[option.id] = option.title
                    })

                    return acc
                }, {})
            },

            fetchOrders() {
                this.sendRequest('get', 'cabinet/orders')
                    .success(response => {
                        this.orders = response.data.orders
                        this.$nextTick(() => {
                            this.initHt()
                        })
                    })
            },

            initHt() {
                window.heightToggle('.js-order-ht')
            },

            orderTotal(priceName, order) {
                return order.products.reduce((acc, product) => {
                    acc += parseFloat(product[priceName])

                    return acc
                }, 0)
            },

            preparedProducts(products) {
                if (_.isEmpty(this.options)) {
                    return
                }

                products.forEach(product => {
                    if (_.isEmpty(product.options)) return

                    product.attributes = []

                    product.options.forEach(optionId => {
                        if (optionId in this.options) {
                            product.attributes.push(this.options[optionId])
                        }
                    })

                    product.attributes = product.attributes.join(', ')

                })

                return products
            },

            orderData(order) {
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
                    if (key in order) {
                        let item = {
                            label: this.$root.translate('form.fields.' + key),
                            value: order[key]
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
