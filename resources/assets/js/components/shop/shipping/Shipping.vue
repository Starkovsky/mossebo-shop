<template>
    <div class="shipping">
        <form class="js-form-inputs">
            <div class="shipping__type d-none">
                <tabs
                    :tabs="shippingTypes"
                    :active="activeShippingType"
                    @activation="setType"
                    :classNameModificators="['xl', 'center', 'underline']"
                    style="margin-bottom: -1px;"
                ></tabs>
            </div>

            <div class="shipping__form">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group js-form-group">
                            <label for="shipping-first-name" class="form-label">
                                {{ $root.translate('form.fields.name') }}
                                <span class="form-required">*</span>
                            </label>

                            <input
                                id="shipping-first-name"
                                type="text"
                                name="shipping[first_name]"
                                :value="data.first_name"
                                @input="input"
                                v-validate="'required|max:255'"
                                class="form-input"
                            >
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group js-form-group">
                            <label for="shipping-last-name" class="form-label">
                                {{ $root.translate('form.fields.surname') }}
                                <span class="form-required">*</span>
                            </label>

                            <input
                                id="shipping-last-name"
                                type="text"
                                name="shipping[last_name]"
                                :value="data.last_name"
                                @input="input"
                                v-validate="'required|max:255'"
                                class="form-input"
                            >
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group js-form-group">
                            <label for="shipping-phone" class="form-label">
                                {{ $root.translate('form.fields.phone') }}
                                <span class="form-required">*</span>
                            </label>

                            <the-mask
                                mask="+7 (###) ###-####"
                                placeholder="+7 (___) ___-____"
                                id="shipping-phone"
                                type="tel"
                                name="shipping[phone]"
                                :value="data.phone.replace('+7', '')"
                                @input="setValue('phone', '+7' + arguments[0])"
                                v-validate="'required|size:12|phone_available'"
                                class="form-input"
                                :masked="false"
                            ></the-mask>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group js-form-group">
                            <label for="shipping-email" class="form-label">
                                {{ $root.translate('form.fields.email') }}
                                <span class="form-required">*</span>
                            </label>

                            <input
                                id="shipping-email"
                                type="text"
                                name="shipping[email]"
                                :value="data.email"
                                @input="input"
                                v-validate="'required|email|min:6|max:255|email_available'"
                                class="form-input"
                            >
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group js-form-group">
                            <label for="shipping-city" class="form-label">
                                {{ $root.translate('form.fields.city') }}
                                <span class="form-required">*</span>
                            </label>

                            <input
                                id="shipping-city"
                                type="text"
                                name="shipping[city]"
                                :value="data.city"
                                @input="input"
                                v-validate="'required|max:255'"
                                class="form-input"
                            >
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group js-form-group">
                            <label for="shipping-post-code" class="form-label">
                                {{ $root.translate('form.fields.post_code') }}
                                <span class="form-required">*</span>
                            </label>

                            <the-mask
                                mask="### ###"
                                placeholder="000 000"
                                id="shipping-post-code"
                                type="text"
                                name="shipping[post_code]"
                                :value="data.post_code"
                                @input="setValue('post_code', arguments[0])"
                                v-validate="'required|digits:6'"
                                class="form-input"
                                :masked="false"
                            ></the-mask>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group js-form-group">
                            <label for="shipping-address" class="form-label">
                                {{ $root.translate('form.fields.address') }}
                                <span class="form-required">*</span>
                            </label>

                            <textarea
                                id="shipping-address"
                                name="shipping[address]"
                                :value="data.address"
                                @input="input"
                                v-validate="'required|max:255'"
                                class="form-textarea"
                            ></textarea>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group js-form-group">
                            <label for="shipping-comment" class="form-label">
                                {{ $root.translate('form.fields.comment') }}
                            </label>

                            <textarea
                                id="shipping-comment"
                                name="shipping[comment]"
                                :value="data.comment"
                                @input="input"
                                v-validate="'max:255'"
                                class="form-textarea"
                            ></textarea>
                        </div>

                        <span class="form-help">
                            {{ $root.translate('shipping.comment_help') }}
                        </span>
                    </div>
                </div>

                <div class="shipping__note">
                    {{ $root.translate('shipping.note') }}
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    // todo: Маску телефона поправить (убрать код?)
    import { TheMask } from 'vue-the-mask'
    import FormValidationMixin from '../../../mixins/FormValidation'

    import Tabs from '../../Tabs'

    export default {
        name: "Shipping",

        mixins: [
            FormValidationMixin
        ],

        components: {
            Tabs,
            TheMask
        },

        methods: {
            input(e) {
                this.setValue(e.target.name.replace('shipping[', '').replace(']', ''), e.target.value)
            },

            setType(type) {
                this.$store.dispatch('shipping/setType', type)
            },

            setValue(name, value) {
                this.$store.dispatch('shipping/setValue', [name, value])
            },
        },

        computed: {
            ... mapState({
                data: state => state.shipping.data,
                shippingTypes: state => state.shipping.types,
                activeShippingType: state => state.shipping.type
            })
        }
    }
</script>
