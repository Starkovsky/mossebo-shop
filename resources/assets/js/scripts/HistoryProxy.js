export default class HistoryProxy {
    constructor() {
        this.proxy = document.createElement('a')
        this.proxy.href = window.location.href

        window.addEventListener('popstate', () => {
            this.proxy.href = window.location.href
        }, { passive: true })
    }

    setHash(hash) {
        this.set('hash', hash)
    }

    getHash() {
        return this.get('hash').replace('#', '')
    }

    get(part) {
        return this.proxy[part]
    }

    set(part, value) {
        this.proxy[part] = value

        this.pushState()
    }

    pushState() {
        window.history.pushState(null, null, this.proxy.href)
    }
}
