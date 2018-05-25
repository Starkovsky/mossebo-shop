import LocalStorageProxy from '../../scripts/LocalStorageProxy'

const cartParamKeys = ['synchronized', 'time', 'items']

export class LocalCart {
    constructor(namespace) {
        this.namespace = namespace
    }

    get() {
        return cartParamKeys.reduce((acc, key) => {
            acc[key] = this.getFromStorage(key)
            return acc
        }, {})
    }

    set(data) {
        LocalCart.checkData(data)

        cartParamKeys.forEach(key => LocalStorageProxy.add(this.makeKey(key), data[key]))
    }

    static checkData(data) {
        cartParamKeys.forEach(key => {
            if (!key in data) {
                throw new Error('Укажите параметр при изменении содержимого корзины: ' + key)
            }
        })
    }

    getFromStorage(key) {
        return LocalStorageProxy.get(this.makeKey(key))
    }

    exists() {
        return LocalStorageProxy.has(this.makeKey('items'))
    }

    makeKey(key) {
        if (! key) {
            return this.namespace
        }

        return `${this.namespace}::${key}`
    }
}

const cart = new LocalCart('__cart')

export default cart
