<template>
    <form class="promo-form" @submit="submit">
        <div class="promo-form__label">
            Есть промокод? Введите его тут:
        </div>

        <div class="promo-form__input">
            <div class="form-group js-form-group">
                <div class="promo-input">
                    <div class="promo-input__main">
                        <div class="promo-input__group form-input-group">
                            <input
                                :value="query"
                                @input="input"
                                name="promo_code"
                                class="promo-input__input form-input js-promo-input"
                                type="text"
                                :disabled="codeAccepted"
                            >
                        </div>
                    </div>

                    <div class="promo-input__side">
                        <template v-if="codeAccepted && !hasError">
                            <button-loading
                                tag="div"
                                :loading="loading"
                                @click="clear"
                                class="promo-input__submit button button-primary"
                            >
                                Сбросить
                            </button-loading>
                        </template>

                        <template v-else>
                            <button-loading
                                :loading="loading"
                                :disabled="queryIsEmpty"
                                type="submit"
                                class="promo-input__submit button button-primary"
                            >
                                Применить
                            </button-loading>
                        </template>
                    </div>
                </div>

                <div class="form-error"></div>
            </div>
        </div>
    </form>
</template>

<script>
    // <div @click="clear" class="form-input-clear">
    //     <svg class="form-input-clear__icon">
    //         <use xlink:href="/assets/images/icons.svg#symbol-close"></use>
    //     </svg>
    // </div>

    import { mapState, mapGetters } from 'vuex'
    import Core from '../../../../scripts/core/index'
    import FormSenderMixin from '../../../../mixins/FormSender'
    import ButtonLoading from '../../../buttons/ButtonLoading'

    export default {
        name: 'promo-form',

        components: {
            ButtonLoading
        },

        mixins: [
            FormSenderMixin
        ],

        data() {
            return {
                query: '',
            }
        },

        created() {
            this.query = this.name
        },

        mounted() {
            this.inputEl = this.$el.querySelector('.js-promo-input')
        },

        methods: {
            getUrl() {
                return Core.siteUrl('cart/promo')
            },

            getData() {
                return {
                    'promo_code': this.query
                }
            },

            input(e) {
                this.query = e.target.value.toUpperCase()
            },

            handleRequest() {
                FormSenderMixin.methods.handleRequest.call(this)
                    .success(response => {
                        this.$store.dispatch('cart/setCart', response.data)
                    })
                    .fail(() => {
                        this.$store.dispatch('cart/promo/clear')
                    })
            },

            clear() {
                this.inputEl.disabled = false

                this.loader.start()

                this.sendRequest('delete', this.getUrl())
                    .success(() => this.$nextTick(this.clearInput))
            },

            clearInput() {
                this.inputEl.focus()
                this.inputEl.setSelectionRange(0, this.inputEl.value.length, 'none')
                document.execCommand('delete')
                this.$store.dispatch('cart/promo/clear')
            },
        },

        computed: {
            queryIsEmpty() {
                return !this.query
            },

            ... mapState({
                name: state => state.cart.promo.name,
                hasError: state => state.cart.promo.hasError,
            }),

            ... mapGetters({
                codeAccepted: 'cart/promo/accepted'
            }),
        }
    }
</script>
