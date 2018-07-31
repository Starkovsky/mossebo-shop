import { FormInputs } from '../scripts/FormSender'
import FormValidationMixin from './FormValidation'
import RequestMixin from '../mixins/RequestMixin'

export default {
    name: 'FormSender',

    mixins: [
        FormValidationMixin,
        RequestMixin
    ],

    props: [
        'url',
    ],

    data() {
        return {
            data$: {},
            clearOnDone: false,
        }
    },

    created() {
        this.defaultData = {
            ... this.data$
        }
    },

    mounted() {
        this.initFormInputs()
    },

    beforeDestroy() {
        this.destroyFormInputs()
    },

    methods: {
        submit(e) {
            e.preventDefault()

            this.abortRequest()
            this.loading = true

            this.$validator.validateAll()
                .then(result => {
                    if (result) {
                        this.sendForm()
                    }
                    else {
                        this.loading = false
                    }
                })
        },

        formSendSuccess() {
            if (this.clearOnDone) {
                this.data$ = { ... this.defaultData }

                this.$nextTick(() => {
                    this.$nextTick(() => {
                        this.$validator.errors.clear()
                    })
                })
            }
        },

        sendForm() {
            let request = this.sendRequest('post', this.url, this.data$)
                .success(this.formSendSuccess)
                .fail(response => {
                    if (request.status !== 'crashed') {
                        this.setErrors(response.data.errors)
                    }
                })
        },

        initFormInputs() {
            this.formInputs = new FormInputs(this.$el)
        },

        destroyFormInputs() {
            if (this.formInputs && 'destroy' in this.formInputs) {
                this.formInputs.destroy()
                this.formInputs = null
            }
        },
    }
}
