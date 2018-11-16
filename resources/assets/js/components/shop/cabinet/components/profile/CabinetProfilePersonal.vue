<template>
    <form>
        <div id="profile-personal-item">
            <h3 class="profile-forms__title title-h3">
                Персональная информация
            </h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group js-form-group">
                        <label for="profile-first-name" class="form-label">
                            {{ $root.translate('form.fields.name') }}
                            <span class="form-required">*</span>
                        </label>

                        <input
                            id="profile-first-name"
                            type="text"
                            name="first_name"
                            v-model="data$.first_name"
                            v-validate="'required|max:255'"
                            class="form-input"
                        >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group js-form-group">
                        <label for="profile-last-name" class="form-label">
                            {{ $root.translate('form.fields.surname') }}
                            <span class="form-required">*</span>
                        </label>

                        <input
                            id="profile-last-name"
                            type="text"
                            name="last_name"
                            v-model="data$.last_name"
                            v-validate="'required|max:255'"
                            class="form-input"
                        >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group js-form-group">
                        <label for="shipping-phone" class="form-label">
                            {{ $root.translate('form.fields.phone') }}
                            <span class="form-required">*</span>
                        </label>

                        <masked-input
                            id="shipping-phone"
                            name="phone"
                            class="form-input"
                            v-model="data$.phone"
                            type="tel"
                            :mask='["+", "7", " ", "(", /[1-69]/, /\d/, /\d/, ")", " ", /\d/, /\d/, /\d/, "-", /\d/, /\d/, /\d/, /\d/]'
                            :guide="true"
                            placeholder="+7 (___) ___-____"
                            v-validate="'required|length:17|phone_available'"
                        ></masked-input>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group js-form-group">
                        <label for="shipping-email" class="form-label">
                            {{ $root.translate('form.fields.email') }}
                            <span class="form-required">*</span>
                        </label>

                        <input
                            id="shipping-email"
                            type="text"
                            name="email"
                            v-model="data$.email"
                            v-validate="'required|email|min:6|max:255|email_available'"
                            class="form-input"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-40" id="profile-address-item">
            <h3 class="profile-forms__title title-h3">
                Адрес доставки
            </h3>

            <div class="row">

                <div class="col-12 col-md-6">
                    <div class="form-group js-form-group">
                        <label for="shipping-city" class="form-label">
                            {{ $root.translate('form.fields.city') }}
                        </label>

                        <input
                            id="shipping-city"
                            type="text"
                            name="city"
                            v-model="data$.city"
                            v-validate="'max:255'"
                            class="form-input"
                        >
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group js-form-group">
                        <label for="shipping-post-code" class="form-label">
                            {{ $root.translate('form.fields.post_code') }}
                        </label>

                        <masked-input
                            id="shipping-post-code"
                            name="post_code"
                            class="form-input"
                            v-model="data$.post_code"
                            type="text"
                            :mask='[/\d/, /\d/, /\d/, " ", /\d/, /\d/, /\d/]'
                            :guide="true"
                            placeholder="___ ___"
                            v-validate="'length:7'"
                        ></masked-input>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group js-form-group">
                        <label for="shipping-street" class="form-label">
                            {{ $root.translate('form.fields.street') }}
                        </label>

                        <input
                            id="shipping-street"
                            type="text"
                            name="street"
                            v-model="data$.street"
                            v-validate="'max:255'"
                            class="form-input"
                        >
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="form-group js-form-group">
                        <label for="shipping-house-number" class="form-label">
                            {{ $root.translate('form.fields.house_number') }}
                        </label>

                        <input
                            id="shipping-house-number"
                            type="text"
                            name="house_number"
                            v-model="data$.house_number"
                            v-validate="'max:255'"
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
                            v-model="data$.apartment"
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
                            v-model="data$.floor"
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
                            v-model="data$.entrance"
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
                            v-model="data$.intercom"
                            v-validate="'max:64'"
                            class="form-input"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-40 text-right">
            <button-loading
                type="submit"
                :loading="loading"
                class="button button-light"
            >
                Сохранить
            </button-loading>
        </div>
    </form>
</template>

<script>
    import MaskedInput from '../../../../MaskedInput'
    import FormSenderMixin from '../../../../../mixins/FormSender'
    import ButtonLoading from '../../../../buttons/ButtonLoading'
    import Number from '../../../../../directives/number'

    export default {
        name: "CabinetProfilePersonal",

        directives: {
            ... Number
        },

        mixins: [
            FormSenderMixin
        ],

        components: {
            MaskedInput,
            ButtonLoading
        },

        props: [
            'data'
        ],

        data() {
            return {
                data$: this.data
            }
        },
    }
</script>
