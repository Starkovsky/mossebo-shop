import { Validator } from 'vee-validate'
import FormSender from '../scripts/FormSender'
import Core from '../scripts/core'

export default {
    data() {
        return {
            formInputs: null
        }
    },

    watch: {
        '$validator.errors.items': 'setVeeErrors'
    },

    created() {
        Validator.localize(Core.getLang())
        this.extendFieldAvailable('email')
        // todo: Добавить форматирование (добавление в начало номера кода страны)
        this.extendFieldAvailable('phone')
    },

    mounted() {
        this.initFormInputs()
    },

    beforeDestroy() {
        this.destroyFormInputs()
    },

    methods: {
        setErrors(errors) {
            if (this.formInputs) {
                this.formInputs.showErrors(errors)
            }
        },

        setVeeErrors() {
            this.setErrors(this.formErrors.items.reduce((acc, item) => {
                acc[item.field] = item.msg

                return acc
            }, {}))
        },

        initFormInputs() {
            this.formInputs = new FormSender(this.$el.querySelector('.js-form-inputs'))
        },

        destroyFormInputs() {
            if (this.formInputs) {
                this.formInputs.destroy()
            }

            this.formInputs = null
        },

        extendFieldAvailable(fieldName) {
            Validator.extend(fieldName + '_available', {
                getMessage: () => this.$root.translate('form.errors.' + fieldName + '_available'),
                validate: value => new Promise(resolve => {
                    axios.post(Core.siteUrl('validate/' + fieldName), {
                        [fieldName]: value
                    })
                        .then(() => {
                            resolve({valid: true})
                        })
                        .catch(response => {
                            if (response.status === 422) {
                                resolve({
                                    valid: false
                                })
                            }
                            // todo: Ошибка соединения с сервером вызывает провал валидации вместо сообщения об ошибке
                            resolve({
                                valid: false
                            })
                        })
                })
            })
        },
    }
}
