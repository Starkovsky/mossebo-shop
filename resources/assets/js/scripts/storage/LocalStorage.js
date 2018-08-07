import BaseStorage from './BaseStorage'

export default class LocalStorage extends BaseStorage {
    constructor() {
        super()

        this.__available = 'localStorage' in window && window['localStorage'] !== null

        if (! this.__available) {
            console.warn('Local storage unavailable.')
        }
    }

    isAvailable() {
        return this.__available
    }

    set(key, data) {
        if (this.isAvailable()) {
            localStorage.setItem(key, this.prepareIncomingData(data))
        }
    }

    get(key) {
        if (!this.isAvailable()) return null

        return this.prepareOutgoingData(localStorage.getItem(key))
    }

    remove(key) {
        if (this.isAvailable()) {
            localStorage.removeItem(key)
        }
    }

    has(key) {
        if (this.isAvailable()) {
            return key in localStorage
        }

        return false
    }

    getKeys() {
        if (this.isAvailable()) {
            return Object.keys(localStorage).filter(key => localStorage.hasOwnProperty(key))
        }

        return []
    }
}
