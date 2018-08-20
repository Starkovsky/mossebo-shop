<template>
    <form class="promo-form" @submit="submit">
        <div class="promo-form__label">
            Есть промокод? Введите его тут:
        </div>

        <div class="promo-form__input">
            <div class="form-group promo-input js-form-group">
                <div class="promo-input__group form-input-group">
                    <div @click="clear" class="form-input-clear">
                        <svg class="form-input-clear__icon">
                            <use xlink:href="/assets/images/icons.svg#symbol-close"></use>
                        </svg>
                    </div>

                    <input
                        v-model="query"
                        class="promo-input__input form-input js-promo-input"
                        type="text">
                </div>

                <template v-if="codeAccepted">
                    <div class="promo-input__success promo-input__side">
                        <svg class="promo-input__success-icon">
                            <use xlink:href="/assets/images/icons.svg#symbol-check"></use>
                        </svg>
                    </div>
                </template>

                <template v-else>
                    <button-loading
                        :loading="loading"
                        :disabled="queryIsEmpty"
                        type="submit"
                        class="promo-input__submit promo-input__side button button-primary"
                    >
                        Применить
                    </button-loading>
                </template>

                <div class="form-error"></div>
            </div>
        </div>

        <div class="promo-form__links">
            <div class="row row--half">
                <div class="promo-form__link">
                    <a href="#" class="icon-link" target="_blank">
                        <svg class="icon-link__icon">
                            <use xlink:href="/assets/images/icons.svg#symbol-search"></use>
                        </svg>

                        Найти другие промокоды
                    </a>
                </div>

                <div class="promo-form__link">
                    <a href="#" class="link" target="_blank">
                        Как получить скидку?
                    </a>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import Core from '../../../scripts/core'
    import FormSenderMixin from '../../../mixins/FormSender'
    import ButtonLoading from '../../buttons/ButtonLoading'

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
                codeAccepted: false
            }
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

            clear() {
                this.$nextTick(() => {
                    this.inputEl.focus()
                    this.inputEl.setSelectionRange(0, this.inputEl.value.length, 'none')
                    document.execCommand('delete')
                })
            }
        },

        computed: {
            queryIsEmpty() {
                return !this.query
            }
        }
    }
</script>
