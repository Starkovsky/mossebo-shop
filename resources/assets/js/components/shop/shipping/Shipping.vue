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
                    <div class="col-12 col-md-6">
                        <div class="form-group js-form-group">
                            <label for="shipping-first-name" class="form-label">
                                {{ $root.translate('form.fields.name') }}
                                <span class="form-required">*</span>
                            </label>

                            <input
                                id="shipping-first-name"
                                type="text"
                                name="first_name"
                                :value="data.first_name"
                                @input="input"
                                v-validate="'required|max:255'"
                                class="form-input"
                            >
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group js-form-group">
                            <label for="shipping-last-name" class="form-label">
                                {{ $root.translate('form.fields.surname') }}
                                <span class="form-required">*</span>
                            </label>

                            <input
                                id="shipping-last-name"
                                type="text"
                                name="last_name"
                                :value="data.last_name"
                                @input="input"
                                v-validate="'required|max:255'"
                                class="form-input"
                            >
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group js-form-group">
                            <label for="shipping-phone" class="form-label">
                                {{ $root.translate('form.fields.phone') }}
                                <span class="form-required">*</span>
                            </label>

                            <masked-input
                                id="shipping-phone"
                                name="phone"
                                class="form-input"
                                :value="data.phone"
                                @input="setValue('phone', arguments[0])"
                                type="tel"
                                :mask='["+", "7", " ", "(", /[1-69]/, /\d/, /\d/, ")", " ", /\d/, /\d/, /\d/, "-", /\d/, /\d/, /\d/, /\d/]'
                                :guide="true"
                                placeholder="+7 (___) ___-____"
                                v-validate="'required|length:17|mask_check:+_ (___) ___-____|phone_available'"
                            ></masked-input>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group js-form-group">
                            <label for="shipping-email" class="form-label">
                                {{ $root.translate('form.fields.email') }}
                                <span class="form-required">*</span>
                            </label>

                            <input
                                id="shipping-email"
                                type="text"
                                name="email"
                                :value="data.email"
                                @input="input"
                                v-validate="'required|email|min:6|max:255|email_available'"
                                class="form-input"
                            >
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group js-form-group">
                            <label for="shipping-city" class="form-label">
                                {{ $root.translate('form.fields.city') }}
                                <span class="form-required">*</span>
                            </label>

                            <input
                                id="shipping-city"
                                type="text"
                                name="city"
                                :value="data.city"
                                @input="input"
                                v-validate="'required|max:255'"
                                class="form-input"
                            >
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group js-form-group">
                            <label for="shipping-post-code" class="form-label">
                                {{ $root.translate('form.fields.post_code') }}
                                <span class="form-required">*</span>
                            </label>

                            <masked-input
                                id="shipping-post-code"
                                name="post_code"
                                class="form-input"
                                :value="data.post_code"
                                @input="setValue('post_code', arguments[0])"
                                type="text"
                                :mask='[/\d/, /\d/, /\d/, " ", /\d/, /\d/, /\d/]'
                                :guide="true"
                                placeholder="___ ___"
                                v-validate="'required|length:7|mask_check:___ ___'"
                            ></masked-input>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group js-form-group">
                            <label for="shipping-street" class="form-label">
                                {{ $root.translate('form.fields.street') }}
                                <span class="form-required">*</span>
                            </label>

                            <input
                                id="shipping-street"
                                type="text"
                                name="street"
                                :value="data.street"
                                @input="input"
                                v-validate="'required|max:255'"
                                class="form-input"
                            >
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="form-group js-form-group">
                            <label for="shipping-house-number" class="form-label">
                                {{ $root.translate('form.fields.house_number') }}
                                <span class="form-required">*</span>
                            </label>

                            <input
                                id="shipping-house-number"
                                type="text"
                                name="house_number"
                                :value="data.house_number"
                                @input="input"
                                v-validate="'required|max:255'"
                                class="form-input"
                            >
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="form-group js-form-group">
                            <label for="shipping-apartment" class="form-label">
                                {{ $root.translate('form.fields.apartment') }}
                            </label>

                            <input
                                id="shipping-apartment"
                                type="text"
                                name="apartment"
                                :value="data.apartment"
                                @input="input"
                                v-validate="'max:64'"
                                class="form-input"
                            >
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group js-form-group">
                            <label for="shipping-floor" class="form-label">
                                {{ $root.translate('form.fields.floor') }}
                            </label>

                            <input
                                id="shipping-floor"
                                type="text"
                                name="floor"
                                :value="data.floor"
                                @input="input"
                                v-number
                                v-validate="'numeric|max:64'"
                                class="form-input"
                            >
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group js-form-group">
                            <label for="shipping-entrance" class="form-label">
                                {{ $root.translate('form.fields.entrance') }}
                            </label>

                            <input
                                id="shipping-entrance"
                                type="text"
                                name="entrance"
                                :value="data.entrance"
                                @input="input"
                                v-validate="'max:64'"
                                class="form-input"
                            >
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group js-form-group">
                            <label for="shipping-intercom" class="form-label">
                                {{ $root.translate('form.fields.intercom') }}
                            </label>

                            <input
                                id="shipping-intercom"
                                type="text"
                                name="intercom"
                                :value="data.intercom"
                                @input="input"
                                v-validate="'max:64'"
                                class="form-input"
                            >
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group js-form-group">
                            <label for="shipping-comment" class="form-label">
                                {{ $root.translate('form.fields.comment') }}
                            </label>

                            <div class="text-length-checker-wrap">
                                <textarea
                                    id="shipping-comment"
                                    name="comment"
                                    :value="data.comment"
                                    @input="input"
                                    v-validate="'max:255'"
                                    class="form-textarea"
                                ></textarea>

                                <div class="text-length-checker-wrap__pos">
                                    <text-length-checker
                                        :text="data.comment"
                                        max="255"
                                    ></text-length-checker>
                                </div>
                            </div>
                        </div>

                        <div class="form-help">
                            {{ $root.translate('shipping.comment_help') }}
                        </div>
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
    import FormValidationMixin from '../../../mixins/FormValidation'
    import Number from '../../../directives/number'
    import TextLengthChecker from '../../TextLengthChecker'
    import Tabs from '../../Tabs'
    import MaskedInput from '../../MaskedInput'

    export default {
        name: "Shipping",

        directives: {
            ... Number
        },

        mixins: [
            FormValidationMixin
        ],

        components: {
            Tabs,
            MaskedInput,
            TextLengthChecker
        },

        methods: {
            input(e) {
                this.setValue(e.target.name.replace('shipping[', '').replace(']', ''), e.target.value)
            },

            setType(type) {
                this.$store.dispatch('shipping/setType', type)
            },

            setValue(name, value) {
                if (this.data[name] !== value) {
                    this.$store.dispatch('shipping/setValue', [name, value])
                }
            },

            phonePipe(newValue) {
                return newValue.replace(new RegExp(/[\s-_()]/g), '')
            }
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
