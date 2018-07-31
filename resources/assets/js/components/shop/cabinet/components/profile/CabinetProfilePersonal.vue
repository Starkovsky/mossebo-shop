<template>
    <form @submit="submit">
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
                        <label for="profile-phone" class="form-label">
                            {{ $root.translate('form.fields.phone') }}
                            <span class="form-required">*</span>
                        </label>

                        <input
                            id="profile-phone"
                            type="tel"
                            name="phone"
                            v-model="data$.phone"
                            v-validate="'required|max:255'"
                            class="form-input"
                        >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group js-form-group">
                        <label for="profile-email" class="form-label">
                            {{ $root.translate('form.fields.email') }}
                            <span class="form-required">*</span>
                        </label>

                        <input
                            id="profile-email"
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
                <div class="col-md-6">
                    <div class="form-group js-form-group">
                        <label for="profile-city" class="form-label">
                            {{ $root.translate('form.fields.city') }}
                        </label>

                        <input
                            id="profile-city"
                            type="text"
                            name="city"
                            v-model="data$.city"
                            v-validate="'max:255'"
                            class="form-input"
                        >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group js-form-group">
                        <label for="profile-post-code" class="form-label">
                            {{ $root.translate('form.fields.post_code') }}
                        </label>

                        <the-mask
                            mask="### ###"
                            placeholder="000 000"
                            id="profile-post-code"
                            type="text"
                            name="post_code"
                            v-model="data$.post_code"
                            v-validate="'digits:6'"
                            class="form-input"
                            :masked="false"
                        ></the-mask>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group js-form-group">
                        <label for="profile-address" class="form-label">
                            {{ $root.translate('form.fields.address') }}
                        </label>

                        <textarea
                            id="profile-address"
                            name="address"
                            v-model="data$.address"
                            v-validate="'max:512'"
                            class="form-textarea"
                        ></textarea>
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
    import { TheMask } from 'vue-the-mask'
    import FormSenderMixin from '../../../../../mixins/FormSender'
    import ButtonLoading from '../../../../buttons/ButtonLoading'

    export default {
        name: "CabinetProfilePersonal",

        mixins: [
            FormSenderMixin
        ],

        components: {
            TheMask,
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

        methods: {

        }
    }
</script>
