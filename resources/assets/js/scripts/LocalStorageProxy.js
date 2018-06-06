// Прослойка между localStorage и app.

// Класс, который можно использовать для хранения данных с определенным пространством имен.
export class LocalStorageProxy {
    constructor(namespace = false) {
        this.__data = {}
        this.__available = 'localStorage' in window && window['localStorage'] !== null
        this.__namespace = namespace
    }

    isAvailable() {
        return this.__available
    }

    prepareKey(key) {
        if (this.__namespace) {
            if (key.indexOf(this.__namespace + '::') === 0) {
                return key
            }

            return this.__namespace + '::' + key
        }

        return key
    }

    keyToShort(key) {
        if (this.__namespace) {
            return key.replace(this.__namespace + '::', '')
        }

        return key
    }

    add(key, data) {
        key = this.prepareKey(key)

        this.__data[key] = data

        if (!this.isAvailable()) return
        if (typeof data === 'function') return

        if (typeof data !== 'string') {
            data = JSON.stringify(data)
        }

        localStorage.setItem(key, data)
    }

    get(key) {
        key = this.prepareKey(key)

        if (key in this.__data) {
            let data = this.__data[key]

            if (typeof data !== 'string') {
                try {
                    data = JSON.parse(JSON.stringify(this.__data[key]))
                }
                catch(e){
                    delete this.__data[key]
                    return this.get(key)
                }
            }

            return data
        }

        if (!this.isAvailable()) return

        let data = localStorage.getItem(key)

        try {
            data = JSON.parse(data)
        }
        catch(e){}

        this.__data[key] = data

        return data
    }

    getAllKeys() {
        let keys = Object.keys(localStorage).filter(key => localStorage.hasOwnProperty(key))

        if (this.__namespace) {
            keys = keys.filter(key => key.indexOf(this.__namespace) === 0)
        }

        return keys
    }

    getAll() {
        return this.getAllKeys().reduce((acc, key) => {
            acc[this.keyToShort(key)] = this.get(key)

            return acc
        }, {})
    }

    has(key) {
        return this.prepareKey(key) in localStorage
    }

    remember(key, getDataFunc, callback) {
        if (! _.isFunction(callback)) return
        key = this.prepareKey(key)

        data = this.get(key)

        if (data) {
            callback(data)
        }
        else {
            try {
                getDataFunc(data => {
                    this.add(key, data)
                    callback(data)
                });
            }
            catch(e) {
                console.log(e)
            }
        }
    }

    forget(key) {
        if (!this.isAvailable()) return

        localStorage.removeItem(this.prepareKey(key))
    }

    forgetAll() {
        this.getAllKeys().forEach(key => this.forget(key))
    }
}

// По-умолчанию без пространства имен.
const defaultProxy = new LocalStorageProxy()

export default defaultProxy
