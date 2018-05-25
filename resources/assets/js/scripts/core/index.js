export default {
    siteUrl(url = '') {
        if (url.indexOf('http') === 0) {
            return url
        }

        return window.location.origin + '/ru/' + _.trim(url, '/')
    },

    apiUrl(url = '') {
        if (url.indexOf('http') === 0) {
            return url
        }

        return window.location.origin + '/api/ru/' + _.trim(url, '/')
    }
}


