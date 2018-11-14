<template>
    <div class="products-views block-ui">
        <loading :loading="loading" style="min-height: 72px">
            <div v-show="! loading">
                <div class="filter-name js-ht-filter is-active">
                    <span class="filter-name__name">
                        Вы смотрели
                    </span>

                    <svg class="filter-name__icon">
                        <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
                    </svg>
                </div>

                <div class="ht-container">
                    <div class="ht-inner">

                        <div class="products-views__cards">
                            <template v-for="product in products">
                                <product-card-views
                                    :key="product.id"
                                    :product="product"
                                ></product-card-views>
                            </template>
                        </div>

                    </div>
                </div>
            </div>
        </loading>
    </div>
</template>

<script>
    import Loading from '../Loading'
    import ProductCardViews from './catalog/product-cards/types/ProductCardViews'
    import ProductViewsHandler from '../../scripts/shop/ProductViewsHandler'
    import Product from '../../scripts/shop/Product'
    import RequestMixin from '../../mixins/RequestMixin'
    import Core from '../../scripts/core'

    export default {
        name: 'products-views',

        mixins: [
            RequestMixin
        ],

        components: {
            ProductCardViews,
            Loading
        },

        data() {
            return {
                products: []
            }
        },

        mounted() {
            let ids = ProductViewsHandler.get(5)

            if (ids.length > 0) {
                this.sendRequest('post', Core.apiUrl('/goods/views'), {ids})
                    .success(response => {
                        if (response.data && response.data.products) {
                            this.products = response.data.products.map(product => new Product(product))

                            this.$nextTick(() => heightToggle(this.$el.querySelector('.js-ht-filter')))
                        }
                    })
            }
        },
    }
</script>
