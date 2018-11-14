<template>
    <loading :loading="loading">
        <div v-show="! loading">
            <div v-if="productIds.length">
                <div class="block-ui">
                    Сортировка
                </div>

                <div class="mt-32">
                    <div class="row">
                        <div class="col-3" v-for="product in products">
                            <product-card-mother
                                :key="product.id"
                                :product="product"
                                :types="'default'"
                            ></product-card-mother>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else>
                Нет товаров для сравнения.
            </div>
        </div>
    </loading>
</template>

<script>
    import { mapState } from 'vuex'
    import DataHandler from "../../../scripts/DataHandler"
    import Loading from '../../Loading'
    import Product from '../../../scripts/shop/Product'
    import Request from '../../../scripts/Request'
    import Core from '../../../scripts/core'
    import ProductCardMother from '../catalog/product-cards/ProductCardMother'

    export default {
        name: 'comparison',

        components: {
            Loading,
            ProductCardMother
        },

        data() {
            return {
                loading: true,
                request: null,
                products: [],
                attributes: []
            }
        },

        created() {
            this.$store.dispatch('comparison/init')
                .then(() =>  Promise.all([
                    DataHandler.get('attributes'),
                    this.fetchProducts()
                ]))
                .then(data => this.init(data))
                .then(() => this.loading = false)
                .catch(() => {
                    this.loading = false
                    this.error = true
                })
        },

        beforeDestroy() {
            if (this.request) {
                this.request.abort()
                this.request = null
            }
        },

        methods: {
            init([data, response]) {
                this.products = response.data.products.map(product => new Product(product))
            },

            fetchProducts() {
                return new Promise(resolve => {
                    this.request = new Request('post', Core.apiUrl('/goods/comparison'), {ids: this.productIds})
                        .success(response => resolve(response))
                        .silent()
                        .start()
                })
            },
        },

        computed: {
            ... mapState({
                productIds: state => state.comparison.ids
            })
        }
    }
</script>
