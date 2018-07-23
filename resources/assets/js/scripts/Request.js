import Core from './core/index'
import axios from 'axios'

const availableMessageTypes = [
    'alert',
    'success',
    'warning',
    'error',
    'info',
]

function runCallback(cb) {
    if (_.isFunction(cb)) {
        cb.apply(null, [].slice.call(arguments, 1))
    }
}

export default class Request {
    constructor(method = 'get', url, data = {}, configParams = {}) {
        this.status = 'crashed'
        this.callbacks = []
        this.fetchRequestCancel = false
        this.isDone = false
        this.response = null
        this.currentUrl = null
        this.started = false

        let config = {
            method: method,
            url: url,
        }

        data = {
            ... data
        }

        if (['post', 'put', 'patch'].indexOf(method) !== -1) {
            config.data = data
        }
        else {
            config.params = data
        }

        this.config = {
            ...config,
            ...configParams,
            cancelToken: new axios.CancelToken(c => this.fetchRequestCancel = c)
        }

        return this
    }

    start() {
        if (this.started) return
        this.started = true
        this.currentUrl = window.location.href

        axios.request(this.config)
            .then(response => {
                this._handleResponse(response)
            })
            .catch(error => {
                if (axios.isCancel(error)) return

                let response = error.response || {}

                if (response.status >= 500) {
                    Core.showMessage(Core.translate('errors.technical'), {type: 'error'})
                    return this._done('crashed')
                }
                else if (response.status === 404) {
                    return this._done('404')
                }
                else if (response.status === 401) {
                    Core.showMessage(response.data.message, {type: 'warning'})
                    return this._done('unauthorized')
                }
                else if ('data' in response && typeof response.data === 'object' && response.data !== null && Object.keys(response.data).length !== 0) {
                    this._handleResponse(response)
                }
            })

        return this
    }

    abort() {
        if (!this.isDone && typeof this.fetchRequestCancel === 'function') {
            this.fetchRequestCancel()
            this.fetchRequestCancel = false
        }
    }

    _handleResponse(response) {
        this.response = response;

        const data = response.data

        if (data.redirect && this.currentUrl === window.location.href) {
            let redirect = data.redirect

            if (redirect.indexOf('/') === 0) {
                redirect = '/' + Core.trim(redirect, '/')
            }

            window.location.href = redirect
            return
        }

        if (data.message) {
            let status = availableMessageTypes.indexOf(data.status) !== -1 ? data.status : undefined

            Core.showMessage(data.message, {type: status})
        }

        this._done(data.status)
    }

    _done(status = 'success') {
        this.isDone = true
        this.status = status

        this.callbacks.forEach(callback => {
            runCallback(callback, this.response)
        })
    }

    _onDone(callback) {
        if (this.isDone) {
            runCallback(callback, this.response)
        }
        else {
            this.callbacks.push(callback)
        }
    }

    success(callback) {
        this._onDone(() => {
            if (this.status === 'success') {
                runCallback(callback, this.response)
            }
        })

        return this
    }

    fail(callback) {
        this._onDone(() => {
            if (this.status === 'error' || this.status === 'unauthorized' || this.status === 'crashed') {
                runCallback(callback, this.response)
            }
        })

        return this
    }

    unauthorized(callback) {
        this._onDone(() => {
            if (this.status === 'unauthorized') {
                runCallback(callback, this.response)
            }
        })

        return this
    }

    crash(callback) {
        this._onDone(() => {
            if (this.status !== 'crashed') return

            runCallback(callback)
        })

        return this
    }

    notFound(callback) {
        this._onDone(() => {
            if (this.status !== '404') return

            runCallback(callback)
        })

        return this
    }

    any(callback) {
        this._onDone(callback)

        return this
    }
}
