import LocalStorage from '../storage/LocalStorage'

class ProductViewsHandler {
    constructor() {
        this.storage = new LocalStorage()
    }

    set(id) {
        let ids = this.storage.get('__productsViews') || []

        if (ids.indexOf(id) !== -1) {
            return
        }

        if (ids.length >= 4) {
            ids = ids.splice(1, ids.length)
        }

        ids.push(id)

        this.storage.set('__productsViews', ids)
    }

    get(count = 4) {
        return (this.storage.get('__productsViews') || []).slice(0, count)
    }
}

const productViewsHandler = new ProductViewsHandler

export default productViewsHandler
