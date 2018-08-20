import Request from '../scripts/Request'

export default {
    data() {
        return {
            loading: false,
            error: false,
            request: null,
        }
    },

    beforeDestroy() {
        this.abortRequest()
    },

    methods: {
        sendRequest(method, url, data) {
            this.abortRequest()

            this.loading = true

            this.request = new Request(method, url, data).start()
            this.hanleRequest()

            return this.request
        },

        hanleRequest() {
            this.request
                .any(this.abortRequest)
                .fail(() => this.error = true)
                .start()
        },

        abortRequest() {
            if (this.request) {
                this.request.abort()
            }

            this.loading = false
            this.request = null
        }
    }
}
