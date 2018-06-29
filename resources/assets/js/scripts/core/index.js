import cookie from './cookie'

export default {
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

    cookie
}


