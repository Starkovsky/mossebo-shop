<template>
    <div class="product-controls">
        <div v-if="selectable.length" class="product-controls__attributes">
            <div class="product-controls-attributes">
                <div class="row">
                    <template v-for="attribute in selectable">
                        <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                            <multi-select
                                v-model="attribute.value"
                                :options="attribute.options"
                                :max-height="300"
                                :placeholder="attribute.title"
                                :searchable="false"
                                :hide-selected="false"
                                :multiple="false"
                                :allow-empty="true"
                                @select="select(attribute)"
                                @remove="select(attribute)"
                                :class="{'has-error': attribute.error}"
                            >

                                <template slot="option" slot-scope="props">
                                    <div :class="'attribute-option attribute-option--' + props.option.id">
                                        {{ props.option.title }}
                                    </div>
                                </template>

                                <template slot="singleLabel" slot-scope="props">
                                    <div :class="'attribute-option attribute-option--' + props.option.id">
                                        {{ props.option.title }}
                                    </div>
                                </template>
                            </multi-select>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="product-controls__buttons">
            <div class="row">
                <div class="col-sm-6 col-md-12 col-xl-6">
                    <button
                        type="button"
                        class="product-controls__button button button-primary"
                        data-toggle="modal"
                        data-target="#exampleModal"
                    >
                        Купить в 1 клик
                    </button>
                </div>

                <div class="col-sm-6 col-md-12 col-xl-6">
                    <template v-if="quantity === 0">
                        <button-loading
                            class="product-controls__button button-dark"
                            :loading="loading"
                            @click="addToCart"
                        >
                            Добавить в корзину
                        </button-loading>
                    </template>

                    <template v-else>
                        <button-loading
                            tag="div"
                            class="product-controls__button button-dark p-0"
                            :loading="loading"
                        >
                            <num-control
                                :number="quantity"
                                @update:number="setQty"
                                :min="1"
                                :max="99"
                                :classNameModificators="['large', 'product']"
                            ></num-control>
                        </button-loading>
                    </template>
                </div>
            </div>
        </div>

        <div class="product-page__socials">
            <div class="product-socials">
                <div class="product-socials__label">
                    Расскажите друзьям:
                </div>

                <div class="product-socials__socials">
                    <div
                        class="uSocial-Share"
                        data-pid="7dcb3e6a17ce539277db2193d1b2a7da"
                        data-type="share"
                        data-options="round,style1,default,absolute,horizontal,size32,counter0"
                        data-social="vk,ok,fb,pinterest,twi,telegram"
                        data-mobile="vi,wa,sms"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import MultiSelect from 'vue-multiselect'
    import NumControl from '../../NumControl'
    import ButtonLoading from '../../buttons/ButtonLoading'
    import { makeKey } from '../../../store/cart/index'

    export default {
        name: "ProductControls",

        components: {
            MultiSelect,
            NumControl,
            ButtonLoading
        },

        data() {
            return {
                id: window.product.id,
                selectable: window.product.selectable,
                options: [],
                a: false
            }
        },

        created() {
        },

        mounted() {
            this.initSocials()
            heightToggle('.js-ht-product-info')
        },

        computed: {
            key() {
                return makeKey(this.id, this.options)
            },

            ... mapState({
                quantity(state) {
                    let item = state.cart.items.find(item => item.hasKey(this.key))

                    if (item) {
                        return item.qty
                    }

                    return 0
                },

                loading(state) {
                    return state.cart.loading
                }
            })
        },

        methods: {
            select(attribute) {
                attribute.error = false

                this.$nextTick(() => {
                    this.collectOptions()
                })
            },

            collectOptions() {
                this.options = this.selectable.reduce((acc, item) => {
                    if (item.value && item.options.find(option => option.id === item.value.id)) {
                        acc.push(item.value.id)
                    }

                    return acc
                }, [])
            },

            addToCart() {
                let canAdd = true

                this.selectable = this.selectable.map(attribute => {
                    if (this.attributeHasError(attribute)) {
                        canAdd = false
                    }

                    return attribute
                })

                if (canAdd) {
                    this.$store.dispatch('cart/addProduct', [{id: this.id, options: this.options}, 1])
                }
            },

            attributeHasError(attribute) {
                if (!attribute.need_to_select) return false

                if (attribute.value && this.options.indexOf(attribute.value.id) !== -1) {
                    return false
                }

                return attribute.error = true
            },

            setQty(qty) {
                this.$store.dispatch('cart/updateProduct', [{id: this.id, options: this.options}, qty])
            },

            initSocials() {
                if (window.uSocial) {
                    window.uSocial.init()
                }
            }
        }
    }
</script>
