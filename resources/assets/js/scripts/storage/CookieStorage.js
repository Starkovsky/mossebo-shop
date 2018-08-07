import BaseStorage from './BaseStorage'

function setCookie(name, value, options) {
    options = options || {}

    let expires = options.expires

    if (typeof expires === "number" && expires) {
        let d = new Date()
        d.setTime(d.getTime() + expires * 1000)
        expires = options.expires = d
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString()
    }

    value = encodeURIComponent(value)

    let updatedCookie = name + "=" + value

    for (let propName in options) {
        updatedCookie += "; " + propName
        let propValue = options[propName]

        if (propValue !== true) {
            updatedCookie += "=" + propValue
        }
    }

    document.cookie = updatedCookie
}

export default class CookieStorage extends BaseStorage {
    set(key, data) {
        let time = new Date
        time.setDate(time.getDate() + 21)

        setCookie(key, this.prepareIncomingData(data), {
            expires: time,
            domain: '.' + window.location.hostname,
            path: '/',
        })
    }

    get(key) {
        let data = this.getAllData()

        if (key in data) {
            return this.prepareOutgoingData(data[key])
        }

        return null
    }

    remove(key) {
        setCookie(key, "", {
            expires: -1
        })
    }

    has(key) {
        return key in this.getAllData()
    }

    getKeys() {
        return Object.keys(this.getAllData())
    }

    getAllData() {
        return document.cookie.split('; ').reduce((acc, current) => {
            const [name, value] = current.split('=')
            acc[name] = value

            return acc
        }, {})
    }
}
