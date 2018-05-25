<template>
    <table v-if="isTable" :class="{'cart-table': true, 'cart-table--small': small}">
        <thead v-if="!noHeader">
            <tr>
                <th>
                    Товары
                </th>

                <th>
                    Цена за штуку
                </th>

                <th>
                    Количество
                </th>

                <th>
                    Цена
                </th>

                <th></th>
            </tr>
        </thead>

        <tbody>
            <template v-for="product in products">
                <cart-product-row
                    :key="product.id"
                    :small="small"
                    :product="product"
                    :quantity.sync="product.quantity"
                    @remove="remove(product.id)"
                ></cart-product-row>
            </template>
        </tbody>
    </table>

    <div v-else>
        <template v-for="product in products">
            <cart-product-item
                :key="product.id"
                :small="small"
                :product="product"
                :quantity.sync="product.quantity"
                @remove="remove(product.id)"
            ></cart-product-item>
        </template>
    </div>
</template>

<script>
    import CartProductRow from './product/CartProductRow'
    import CartProductItem from './product/CartProductItem'

    import ClassNameWithModificators from '../../../mixins/ClassNameWithModificators'

    export default {
        name: "CartTable",

        components: {
            CartProductRow,
            CartProductItem,
        },

        mixins: [
            ClassNameWithModificators
        ],

        props: {
            'no-header': {
                type: Boolean,
                default: false,
            },

            small: Boolean,

            products: {
                type: Array,
                default: () => []
            },
        },

        data() {
            return {
                breakpoint: 768
            }
        },

        computed: {
            isTable() {
                return this.$root.windowMoreThan('md')
            },

            className() {
                let baseClass = 'cart-table'
                let addModif = (acc, modif) => acc + ' ' + baseClass + '--' + modif

                if (_.isArray(this.modif)) {
                    return this.modif.reduce(addModif, baseClass)
                }

                if (_.isString(this.modif)) {
                    return addModif(baseClass, this.modif)
                }

                return baseClass
            },
        }
    }
</script>
