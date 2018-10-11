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

function prepareData(data) {
    let token = Core.user.getToken()

    if (data instanceof FormData) {
        if (token) {
            data.append('api_token', token)
        }
    }
    else if (data instanceof Object) {
        data = {
            ... data
        }

        if (token) {
            data.api_token = token
        }
    }

    return data
}

export default class Request {
    constructor(method = 'get', url, data = {}, configParams = {}) {
        this.status = null
        this.callbacks = []
        this.fetchRequestCancel = false
        this.isDone = false
        this.response = null
        this.currentUrl = null
        this.started = false
        this.canShowMessages = true

        let config = {
            method: method,
            url: url,
        }

        data = prepareData(data)

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

    silent() {
        this.canShowMessages = false

        return this
    }

    _showMessage(message, options) {
        if (this.canShowMessages) {
            Core.showMessage(message, options)
        }
    }

    start() {
        if (this.started) return
        this.started = true
        this.currentUrl = window.location.href

        axios.request(this.config)
            .then(response => {
                this._setStatus('success')
                this._handleResponse(response)
            })
            .catch(error => {
                if (axios.isCancel(error)) return
                console.error(error)

                let response = error.response || {}

                if (response.status === 404) {
                    this._setStatus('404')
                }
                else if (response.status === 401) {
                    this._setStatus('unauthorized')
                }

                if ('data' in response && typeof response.data === 'object' && response.data !== null && Object.keys(response.data).length !== 0) {
                    this._handleResponse(response)
                }
                else {
                    this._setStatus('crashed')
                    this._showMessage(Core.translate('errors.technical'), {type: 'error'})
                    this._done()
                }
            })

        return this
    }

    _setStatus(status) {
        if (! this.status) {
            this.status = status
        }
    }

    abort() {
        if (!this.isDone && typeof this.fetchRequestCancel === 'function') {
            this.fetchRequestCancel()
            this.fetchRequestCancel = false
        }
    }

    _handleResponse(response) {
        this.response = response

        const data = response.data

        if (data.redirect && this.currentUrl === window.location.href) {
            let redirect = data.redirect

            if (redirect.indexOf('/') === 0) {
                redirect = '/' + Core.trim(redirect, '/')
            }

            window.location.href = redirect
            return
        }

        if ('status' in data) {
            this._setStatus(data.status)
        }

        if (data.message) {
            let status = availableMessageTypes.indexOf(this.status) !== -1 ? {type: this.status} : undefined

            this._showMessage(data.message, status)
        }

        if ('meta' in data) {
            Core.setMeta(data.meta)
        }

        this._done()
    }

    _done() {
        this.isDone = true

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
