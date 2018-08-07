// Прослойка между localStorage и app.
import BaseStorageProxy from './BaseStorageProxy'
import LocalStorage from './LocalStorage'

export class LocalStorageProxy extends BaseStorageProxy {
    constructor(namespace) {
        super(new LocalStorage, namespace)
    }
}

// По-умолчанию без пространства имен.
const defaultProxy = new LocalStorageProxy()

export default defaultProxy
