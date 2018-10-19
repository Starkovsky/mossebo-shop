<template>
    <loading :loading="loading">
        <div v-if="error"></div>

        <div v-else-if="saleNotExist" class="product-card-sale block-ui"></div>

        <product-card-sale-big
            v-else
            :product="product"
            class="block-ui block-ui--with-hover"
        ></product-card-sale-big>
    </loading>
</template>

<script>
    import Core from '../../../scripts/core/index'
    import Loading from '../../Loading'
    import ProductCardSaleBig from '../catalog/product-cards/types/ProductCardSaleBig'
    import RequestMixin from '../../../mixins/RequestMixin'
    import Product from '../../../scripts/shop/Product'

    export default {
        name: "ProductSale",

        mixins: [
            RequestMixin
        ],

        components: {
            ProductCardSaleBig,
            Loading,
        },

        data() {
            return {
                product: null,
            }
        },

        created() {
            this.fetchItem()
        },

        methods: {
            fetchItem() {
                this.sendRequest('get', Core.apiUrl('sale'))
                    .success(response => this.setProduct(response.data.product))
                    .silent()
            },

            setProduct(data) {
                this.product = new Product(data)

                this.$watch('product.sale.status', value => {
                    if (value === 'finished') {
                        this.product = null
                        this.fetchItem()
                    }
                })
            }
        },

        computed: {
            saleNotExist() {
                return ! (
                    this.product &&
                    this.product.hasSale() &&
                    this.product.sale.isActual()
                )
            }
        }
    }
</script>
