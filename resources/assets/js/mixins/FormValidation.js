import { Validator } from 'vee-validate'
import FormSender from '../scripts/FormSender'
import Request from '../scripts/Request'
import Core from '../scripts/core'


class ValidationExtension {
    constructor(fieldName) {
        this.fieldName = fieldName
        this.request = null
        this.message = null
        this.validate = value => this._validate(value)
        this.getMessage = () => this._getMessage()
        this.requestDebouncer = _.debounce((resolve, value) => this.sendRequest(resolve, value), 128)
    }

    cancelRequest() {
        if (! this.request) return

        this.request.abort()
        this.request = null
    }

    _validate(value) {
        this.cancelRequest()

        return new Promise(resolve => {
            this.requestDebouncer(resolve, value)
        })
    }

    sendRequest(resolve, value) {
        return resolve({
            valid: true
        })
    }

    _getMessage() {
        if (this.message) {
            return this.message
        }

        return this.getMessageByFieldName()
    }

    getMessageByFieldName() {
        return Core.translate('form.errors.' + this.fieldName)
    }

    setMessage(message) {
        this.message = message
    }
}

class FieldAvailableExtension extends ValidationExtension {
    getUrl() {
        return Core.siteUrl('validate/' + this.fieldName)
    }

    sendRequest(resolve, value) {
        this.request = new Request('post', this.getUrl(), {
            [this.fieldName]: value
        })
            .success(() => resolve({
                valid: true
            }))
            .fail(response => {
                if (response.status === 422) {
                    let message = _.get(response, 'data.errors.' + this.fieldName)

                    if (message) {
                        this.setMessage(message[0])

                        resolve({
                            valid: false,
                            errors: message
                        })

                        return
                    }
                }

                resolve({
                    valid: false
                })
            })
            .silent()
            .start()
    }

    getMessageByFieldName() {
        return Core.translate('validation.errors.' + this.fieldName + '_available')
    }
}

class MaskCheckExtension {
    validate(value, args) {
        let mask = args[0]

        mask = mask.split('').reverse()
        value = value.split('').reverse()

        for (let i = 0; i < mask.length; i++) {
            if (mask[i] === '_' && mask[i] === value[i]) {
                return false
            }
        }

        return true
    }
}

const getMessages = (function () {
    let messages = null

    function initMessages() {
        messages = Core.translate('validation.errors')

        Object.keys(messages).forEach(function(key) {
            let message = messages[key]

            messages[key] = (fieldName, values) => {
                if (message.indexOf(':fieldName') !== -1) {
                    message = message.replace(':fieldName', `"${fieldName}"`)
                }

                for (let i = 0; i < values.length; i++) {
                    if (message.indexOf(':value-' + i) !== -1) {
                        message = message.replace(':value-' + i, values[i])
                    }
                }

                return message
            }
        })
    }

    return function() {
        if (! messages) {
            initMessages()
        }

        return messages
    }
}());

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
        let messages = getMessages()

        this.$validator.localize({
            [Core.getLang()]: {
                messages,
                attributes: Core.translate('form.fields'),
            }
        })

        this.extendFieldAvailable('email')
        // todo: Добавить форматирование (добавление в начало номера кода страны)
        this.extendFieldAvailable('phone')
        this.extendMaskChecker()
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
            Validator.extend(fieldName + '_available', new FieldAvailableExtension(fieldName), {
                immediate: true
            })
        },

        extendMaskChecker() {
            Validator.extend('mask_check', new MaskCheckExtension)
        }
    }
}
