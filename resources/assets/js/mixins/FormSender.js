import { FormInputs } from '../scripts/FormSender'
import FormValidationMixin from './FormValidation'
import RequestMixin from '../mixins/RequestMixin'
import { makeLoader } from '../scripts/PendingLoader'

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
            loader: makeLoader(
                () => this.sendForm(),
                () => this.abortRequest(),
                1000
            )
        }
    },

    created() {
        this.defaultData = {
            ... this.data$
        }
    },

    methods: {
        submit(e) {
            e.preventDefault()

            this.abortRequest()
            this.loading = true

            this.$validator.validateAll()
                .then(result => {
                    if (result) {
                        this.loader.start()
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
            this.sendRequest(this.getMethod(), this.getUrl(), this.getData())
                .success(this.formSendSuccess)
        },

        handleRequest() {
            return this.request.fail(response => {
                this.error = true

                if (this.request.status !== 'crashed') {
                    this.setErrors(response.data.errors)
                }
            })
            .any(() => this.loader.finish())
        },

        getMethod() {
            return 'post'
        },

        getUrl() {
            return this.url
        },

        getData() {
            return this.data$
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
