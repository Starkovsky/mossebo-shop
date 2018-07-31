<template>
    <form @submit="submit">
        <h3 class="profile-forms__title title-h3">
            Изменение пароля
        </h3>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group js-form-group">
                    <label for="profile-password" class="form-label">
                        {{ $root.translate('form.fields.password_old') }}
                        <span class="form-required">*</span>
                    </label>

                    <input
                        id="profile-password"
                        type="password"
                        name="password"
                        v-model="data$.password"
                        v-validate="'required|min:6|max:255'"
                        class="form-input"
                    >
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group js-form-group">
                    <label for="profile-password-new" class="form-label">
                        {{ $root.translate('form.fields.password_new') }}
                        <span class="form-required">*</span>
                    </label>

                    <input
                        id="profile-password-new"
                        type="password"
                        name="password_new"
                        ref="password_new"
                        v-model="data$.password_new"
                        v-validate="'required|min:6|max:255'"
                        class="form-input"
                    >
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group js-form-group">
                    <label for="profile-password-confirm" class="form-label">
                        {{ $root.translate('form.fields.password_confirm') }}
                        <span class="form-required">*</span>
                    </label>

                    <input
                        id="profile-password-confirm"
                        type="password"
                        name="password_new_confirmation"
                        v-model="data$.password_new_confirmation"
                        v-validate="'required|confirmed:$password_new|min:6|max:255'"
                        class="form-input"
                    >
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

        data() {
            return {
                data$: {
                    password: '',
                    password_new: '',
                    password_new_confirmation: ''
                },

                clearOnDone: true
            }
        },

        methods: {

        }
    }
</script>
