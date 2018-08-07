// Прослойка между Cookie и app.
import BaseStorageProxy from './BaseStorageProxy'
import CookieStorage from './CookieStorage'

export class CookieStorageProxy extends BaseStorageProxy {
    constructor(namespace) {
        super(new CookieStorage, namespace)
    }
}

// По-умолчанию без пространства имен.
const defaultProxy = new CookieStorageProxy()

export default defaultProxy
