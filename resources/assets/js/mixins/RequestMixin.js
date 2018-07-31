import Request from '../scripts/Request'

export default {
    data() {
        return {
            loading: false,
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

            return this.request = new Request(method, url, data)
                .any(this.abortRequest)
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
