import cookie from './cookie'
import Alerty from '../Alerty'
import setMeta from '../MetaSetter'
import timeHandler from './time'
import metrika from './metrika'

let Core = {
    siteUrl(url = '') {
        if (url.indexOf('http') === 0) {
            return url
        }

        return window.location.origin + '/' + this.getLang() + '/' + _.trim(url, '/')
    },

    apiUrl(url = '') {
        if (url.indexOf('http') === 0) {
            return url
        }

        return window.location.origin + '/api/' + this.getLang() + '/' + _.trim(url, '/')
    },

    translate(identif, data = {}) {
        return _.get(window.mossebo.translates, identif)
    },

    getLang() {
        return 'ru'
    },

    config(path) {
        return _.get(window.mossebo, path);
    },

    canUsePromo() {
        let user = this.config('user');

        return ! (user && user.promoDisabled)
    },

    cookie,
    metrika,
    setMeta,

    getFancyboxConfig() {
        return {
            toolbar: false,
            infobar: false,
            arrows: false,
            buttons: ['close'],
            protect: false,

            touch: false,
            hash: false,

            lang: this.getLang(),
            loop: true,

            autoFocus: true,

            i18n: {
                [this.getLang()]: this.translate('fancybox')
            },

            mobile : {
                clickContent : "close",
                clickSlide : "close"
            }
        }
    },

    getParameterByName(name, url) {
        url = url || window.location.href
        name = name.replace(/[\[\]]/g, '\\$&')

        let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url)

        if (!results) return null
        if (!results[2]) return ''

        return decodeURIComponent(results[2].replace(/\+/g, ' '))
    },

    updateQueryStringParameter(uri, key, value) {
        let regex = new RegExp("([?&])" + key + "=.*?(&|$)", "i")
        let separator = uri.indexOf('?') !== -1 ? "&" : "?"

        value = encodeURIComponent(value)

        if (uri.match(regex)) {
            if (value) {
                return uri.replace(regex, '$1' + key + "=" + value + '$2')
            }

            return uri.replace(regex, '')
        }
        else {
            if (value) {
                return uri + separator + key + "=" + value
            }

            return uri
        }
    },

    history: {
        replace(uri) {
            window.history.replaceState({}, document.title, uri)
        }
    },

    showMessage(message, params = {}) {
        if (message) {
            new Alerty({
                message: message,
                ... params
            })
        }
    },


    user: {
        getToken() {
            return Core.config('user.token')
        }
    },
}

Core.time = new timeHandler(Core.config('base_time'))

export default Core

