<template>
    <loading :loading="loading">
        <div v-if="error"></div>

        <div v-else-if="saleNotExist" class="product-card-sale block-ui"></div>

        <product-card-sale
            v-else
            :product="product"
        ></product-card-sale>
    </loading>
</template>

<script>
    import Core from '../../../scripts/core/index'
    import Loading from '../../Loading'
    import ProductCardSale from '../catalog/product-cards/types/ProductCardSale'
    import RequestMixin from '../../../mixins/RequestMixin'
    import Product from '../../../scripts/shop/Product'

    export default {
        name: "ProductSale",

        mixins: [
            RequestMixin
        ],

        components: {
            ProductCardSale,
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
                    .success(response => {
                        this.product = new Product(response.data.product)
                    })
                    .silent()
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
