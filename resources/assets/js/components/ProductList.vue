<template>
    <div class="product-list">
        <div class="container">
            <div class="row">
                <div class="col-md-3"
                     v-for="Product in Products"
                     :key="Product.id"
                >
                    <product-card
                        :product="Product"
                    >
                    </product-card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ProductCard from "./ProductCard";
    export default {
        name: "ProductList",
        components: {
            ProductCard
        },
        data () {
            return {
                Products: {
                    1: {
                        'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
                        'image': '//p.fast.ulmart.ru/p/gen/366/36605/3660569.jpg',
                        'price': '16310',
                        'old_price': '18310'
                    },
                    2: {
                        'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
                        'image': '//p.fast.ulmart.ru/p/gen/366/36605/3660569.jpg',
                        'price': '16310',
                        'old_price': '18310'
                    },
                    3: {
                        'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
                        'image': '//p.fast.ulmart.ru/p/gen/366/36605/3660569.jpg',
                        'price': '16310',
                        'old_price': '18310'
                    },
                    4: {
                        'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
                        'image': '//p.fast.ulmart.ru/p/gen/366/36605/3660569.jpg',
                        'price': '1631040',
                        'old_price': '18310'
                    },
                    5: {
                        'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
                        'image': '//p.fast.ulmart.ru/p/gen/366/36605/3660569.jpg',
                        'price': '16310',
                        'old_price': '18310'
                    },
                    6: {
                        'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
                        'image': '//p.fast.ulmart.ru/p/gen/366/36605/3660569.jpg',
                        'price': '16310',
                        'old_price': '18310'
                    },
                    7: {
                        'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
                        'image': '//p.fast.ulmart.ru/p/gen/366/36605/3660569.jpg',
                        'price': '16310',
                        'old_price': '18310'
                    },
                    8: {
                        'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
                        'image': '//p.fast.ulmart.ru/p/gen/366/36605/3660569.jpg',
                        'price': '16310',
                        'old_price': '18310'
                    },
                    9: {
                        'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
                        'image': '//p.fast.ulmart.ru/p/gen/366/36605/3660569.jpg',
                        'price': '16310',
                        'old_price': '18310'
                    },
                    10: {
                        'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
                        'image': '//p.fast.ulmart.ru/p/gen/366/36605/3660569.jpg',
                        'price': '16310',
                        'old_price': '18310'
                    },
                    11: {
                        'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
                        'image': '//p.fast.ulmart.ru/p/gen/366/36605/3660569.jpg',
                        'price': '16310',
                        'old_price': '18310'
                    },
                    12: {
                        'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
                        'image': '//p.fast.ulmart.ru/p/gen/366/36605/3660569.jpg',
                        'price': '16310',
                        'old_price': '18310'
                    },
                    13: {
                        'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
                        'image': '//p.fast.ulmart.ru/p/gen/366/36605/3660569.jpg',
                        'price': '16310',
                        'old_price': '18310'
                    },
                    14: {
                        'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
                        'image': '//p.fast.ulmart.ru/p/gen/366/36605/3660569.jpg',
                        'price': '16310',
                        'old_price': '18310'
                    },
                    15: {
                        'name': 'Столик-оттоманка, иск.кожа (2561BL), цвет черный',
                        'image': '//p.fast.ulmart.ru/p/gen/366/36605/3660569.jpg',
                        'price': '16310',
                        'old_price': '18310'
                    },
                }
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
