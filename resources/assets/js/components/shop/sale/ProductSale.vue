<template>
    <loading :loading="loading">
        <div v-if="error">

        </div>

        <div v-else-if="!product" class="product-card-sale block-ui"></div>

        <product-card-sale
            v-else
            :product="product"
            :saleTime="saleTime"
            :small="small"
        ></product-card-sale>
    </loading>
</template>

<script>
    // <banner-home-stock></banner-home-stock>
    import axios from 'axios'
    import Core from '../../../scripts/core/index'
    import Loading from '../../Loading'
    import ProductCardSale from '../catalog/product-cards/ProductCardSale'

    // import BannerHomeStock from '../../banners/BannerHomeStock'

    export default {
        name: "ProductSale",

        components: {
            ProductCardSale,
            Loading,
            // BannerHomeStock
        },

        data() {
            return {
                loading: false,
                error: false,
                product: null,
                saleTime: 0
            }
        },

        created() {
            this.fetchItem()
        },

        beforeDestroy() {
            if (this.requestCanceler) {
                this.requestCanceler.cancel()
                this.requestCanceler = undefined
            }
        },

        methods: {
            fetchItem() {
                this.loading = true
                this.requestCanceler = axios.CancelToken.source()

                axios.get(Core.apiUrl('sale'), {
                    cancelToken: this.requestCanceler.token
                })
                    .then(response => {
                        this.saleTime = parseInt(response.data.sale_time)
                        this.product = response.data.product
                    })
                    .catch(e => {
                        if (! axios.isCancel(e)) {
                            console.log(e)
                            this.error = true
                        }
                    })
                    .finally(() => {
                        this.loading = false
                    })
            }
        },

        computed: {
            small() {
                return this.$root.windowLessThan('sm') || (this.$root.windowMoreThan('lg') && this.$root.windowLessThan('xl'))
            }
        }
    }
</script>
