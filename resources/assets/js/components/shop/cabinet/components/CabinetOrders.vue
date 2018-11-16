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
                        <div v-for="order in orders" class="cabinet-orders__item col-12" :key="order.id">
                            <div class="cabinet-order block-ui block-ui--with-hover">
                                <div class="cabinet-order__panel js-order-ht">
                                    <cabinet-order-panel
                                        :id="order.id"
                                        :status="order.status"
                                    ></cabinet-order-panel>
                                </div>

                                <div class="cabinet-order__hidden ht-container">
                                    <div class="cabinet-order__inner ht-inner">
                                        <order-info
                                            :order="order"
                                        ></order-info>
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
    import DataHandler from '../../../../scripts/DataHandler'
    import CabinetOrderPanel from './orders/CabinetOrderPanel'
    import OrderInfo from '../../order/OrderInfo'

    export default {
        name: "CabinetOrders",

        components: {
            Loading,
            CabinetOrderPanel,
            OrderInfo
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
                        this.setOrders(response.data.orders)

                        this.$nextTick(() => {
                            this.initHt()
                        })
                    })
            },

            initHt() {
                window.heightToggle('.js-order-ht')
            },

            setOrders(orders) {
                if (!_.isEmpty(this.options)) {
                    orders.forEach(order => {
                        this.prepareProducts(order.products)
                    })
                }

                this.orders = orders
            },

            prepareProducts(products) {
                products.forEach(product => {
                    product.key = product.id

                    if (_.isEmpty(product.options)) return

                    product.attributes = []

                    product.options.forEach(optionId => {
                        if (optionId in this.options) {
                            product.attributes.push(this.options[optionId])
                            product.key += '-' + optionId
                        }
                    })

                    product.attributes = product.attributes.join(', ')
                })
            },
        },
    }
</script>
