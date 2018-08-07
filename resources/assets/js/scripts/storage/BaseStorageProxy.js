// Класс, который можно использовать для хранения данных с определенным пространством имен.
export default class BaseStorageProxy {
    constructor(storage, namespace = false) {
        this.__data = {}
        this.__storage = storage
        this.__namespace = namespace
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

        this.__storage.set(key, data)
    }

    get(key) {
        key = this.prepareKey(key)

        if (key in this.__data) {
            if (typeof this.__data[key] === 'object') {
                try {
                    return JSON.parse(JSON.stringify(this.__data[key]))
                }
                catch(e){
                    delete this.__data[key]
                    return this.get(key)
                }
            }
        }

        this.__data[key] = this.__storage.get(key)

        return this.__data[key]
    }

    getAllKeys() {
        let keys = this.__storage.getKeys()

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
        return this.__storage.has(this.prepareKey(key))
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
        this.__storage.remove(this.prepareKey(key))
    }

    forgetAll() {
        this.getAllKeys().forEach(key => this.forget(key))
    }
}
