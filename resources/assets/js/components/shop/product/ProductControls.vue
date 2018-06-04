<template>
    <div class="product-controls">
        <div v-if="selectable.length" class="product-controls__attributes">
            <div class="product-controls-attributes">
                <template v-for="attribute in selectable">
                    <div class="product-controls-attributes__item">
                        <multi-select
                            v-model="attribute.value"
                            :options="attribute.options"
                            :max-height="300"
                            :placeholder="attribute.title"
                            :searchable="false"
                            :hide-selected="false"
                            :multiple="false"
                            :allow-empty="true"
                            @select="select"
                            @remove="select"
                        >

                            <template slot="option" slot-scope="option">
                                <div :class="'attribute-option attribute-option--' + option.option.id">
                                    {{ option.option.title }}
                                </div>
                            </template>
                        </multi-select>
                    </div>
                </template>
            </div>
        </div>

        <div v-show="quantity > 0" class="product-controls__attributes">
            <div class="mb-5">
                <div class="row">
                    <div class="col-md-3 d-flex align-items-center">
                        <span>Количество:</span>
                    </div>
                    <div class="col-md-5">
                        <num-control
                            :value="quantity"
                            :min="1"
                            :max="99"
                        ></num-control>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="product-controls__buttons py-3">
                <div class="row">
                    <div class="col-sm-6">
                        <button type="button"
                                class="button button-dark"
                                data-toggle="modal"
                                data-target="#exampleModal"
                        >
                            Купить в 1 клик
                        </button>
                    </div>

                    <div class="col-sm-6">
                        <button type="button"
                                class="button button-primary js-product-add"
                                @click="addToCart"
                        >
                            Добавить в корзину
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import MultiSelect from 'vue-multiselect'
    import NumControl from '../../NumControl'
    import { makeKey } from '../../../store/cart/index'

    export default {
        name: "ProductControls",

        components: {
            MultiSelect,
            NumControl
        },

        data() {
            return {
                id: window.product.id,
                selectable: window.product.selectable,
                options: []
            }
        },

        created() {

        },

        mounted() {

        },

        computed: {
            key() {
                return makeKey(this.id, this.options)
            },

            ... mapState({
                quantity: state => {
                    let item = state.cart.items.find(item => item.hasKey(this.key))

                    if (item) {
                        return item.qty
                    }

                    return 0
                }
            })
        },

        methods: {
            select() {
                this.options = this.selectable.reduce((acc, item) => {
                    if (item.value && item.options.find(option => option.id === item.value.id)) {
                        acc.push(item.value.id)
                    }

                    return acc
                }, [])
            },

            addToCart() {
                let attributes = this.selectable
                let canAdd = true

                for (let i = 0; i < attributes.length; i++) {
                    if (attributes[i]['need_to_select'] && this.options.indexOf(attributes[i].value) === -1) {
                        attributes[i].error = true
                        canAdd = false
                    }
                }

                if (canAdd) {
                    this.$store.dispatch('cart/addProduct', [{id: this.id, options}, 1])
                }
            },
        }
    }
</script>
