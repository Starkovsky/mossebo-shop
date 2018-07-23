export default class wBlankPlugin {
    constructor() {
        this.subscribers = []
        this.eventDestroyers = []
        this.opened = false
    }

    on(name, callback) {
        if (typeof callback !== 'function') return

        if (! this.subscribers[name]) {
            this.subscribers[name] = []
        }

        this.subscribers[name].push(callback)

        return () => {
            this.off(name, callback)
        }
    }

    one(name, callback) {
        if (typeof callback !== 'function') return

        let handler = () => {
            callback.apply(null, arguments)
            this.off(name, handler)
        }

        this.on(name, handler)
    }

    once() {
        this.one.apply(this, arguments)
    }

    off(name, callback) {
        if (!this.subscribers[name]) return

        if (typeof callback === 'undefined') {
            delete this.subscribers[name]
        }
        else if (typeof callback === 'function') {
            let index = this.subscribers[name].indexOf(callback)

            if (index !== -1) {
                if (this.subscribers[name].length === 1) {
                    delete this.subscribers[name]
                }
                else {
                    this.subscribers[name].splice(index, 1)
                }
            }
        }
    }

    trigger(name) {
        let data = [].slice.call(arguments, 1)

        if (! this.subscribers[name]) return

        [...this.subscribers[name]].forEach(eventCallback => {
            eventCallback.apply(null, data)
        })
    }

    cleanSubscribers() {
        this.subscribers = {}
    }

    call(name) {
        if (typeof this[name] === 'function') {
            this[name]()
        }
    }

    bindEvent(el, name, cb, options = {}) {
        cb = cb.bind(this)

        this.eventDestroyers.push(() => {
            el.removeEventListener(name, cb)
        })

        el.addEventListener(name, cb, options)
    }

    unbindEvents() {
        this.eventDestroyers.forEach(cb => cb())
    }

    destroy() {
        this.call('beforeDestroy')
        this.unbindEvents()
        this.cleanSubscribers()
    }
}
