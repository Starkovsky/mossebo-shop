function roundPrice(price) {
    return Math.ceil(price)
}

export default class Cart {
    constructor() {
        this.items = []
        this.promo = null
    }

    findOrMakeItemByKey(key) {
        for (let i = 0; i < this.items.length; i++) {
            if (this.items[i].hasKey(key)) {
                return this.items[i]
            }
        }

        return new CartItem(key)
    }

    add(key, quantity) {
        this.findOrMakeItemByKey(key).add(quantity)
        this.hasChanged()
    }

    set(key, quantity) {
        this.findOrMakeItemByKey(key).set(quantity)
        this.hasChanged()
    }

    remove(key) {
        this.items = this.items.filter(item => !item.hasKey(key))
    }

    setProducts(items = []) {
        this.items = items.map(item => {
            if (item instanceof CartItem) return item

            let ci = new CartItem(item.key, item.quantity)

            if (item.info){
                ci.setProductInfo(item.info)
            }

            return ci
        })
    }

    setPromo(promo) {
        this.promo = promo
        this.hasChanged()
    }

    removePromo() {
        this.setPromo(null)
    }

    hasChanged() {
        this.quantity = null
        this.amount = null
    }

    getProductsQuantity() {
        return this.items.reduce((acc, item) => acc + item.getQuantity(), 0)
    }

    getItems() {
        return this.items
    }

    getProducts() {
        return this.items.map(this.toProduct)
    }

    getProductByKey(key) {
        return this.toProduct(
            this.getItemByKey(key)
        )
    }

    getItemByKey(key) {
        return this.items.find(item => item.hasKey(key))
    }

    toProduct(item) {
        if (!item) {
            return null
        }

        return {
            ... item.getInfo(),
            quantity: item.getQuantity(),
            key: item.getKey()
        }
    }

    getAmount() {
        if (_.isEmpty(this.amount)) {
            this.amount = this.items.reduce((acc, item) => {
                acc += item.getAmount()

                return acc
            }, 0)
        }

        return roundPrice(this.amount)
    }

    getPromoDiscount() {
        let discount = 0

        if (! this.promo) {
            return discount
        }

        return roundPrice(
            this.promo.getDiscount(this.getAmount())
        )
    }

    getTotal() {
        return roundPrice(
            this.getAmount() - this.getPromoDiscount()
        )
    }
}

export class CartItem {
    static makeKey(id, options = []) {
        return options.sort((a, b) => a - b).reduce((acc, optionId) => {
            return acc + '-' + optionId
        }, id)
    }

    constructor(key, quantity = 0) {
        this.key = key.toString()
        this.setQuantity(quantity)
        this.loaded = false
    }

    getKey() {
        return this.key
    }

    hasKey(key) {
        if (! key) return false
        return this.key === key.toString()
    }

    setQuantity(quantity) {
        this.quantity = Math.min(
            this.getMaxQuantity(),
            Math.max(this.getMinQuantity(), quantity)
        )
    }

    getMaxQuantity() {
        // if (this.loaded && _.isNumber(this.info.remnant)) {
        //     return this.info.remnant
        // }

        return 99
    }

    getMinQuantity() {
        return 1
    }


    getQuantity() {
        return this.quantity
    }

    getPrice() {
        if (this.isLoaded()) {
            return this.info.price
        }

        return 0
    }

    getAmount() {
        return this.getQuantity() * this.getPrice()
    }


    add(quantity) {
        this.setQuantity(this.quantity + quantity)

        return this
    }

    set(quantity) {
        this.setQuantity(quantity)

        return this
    }

    isLoaded() {
        return this.loaded
    }

    getInfo() {
        return this.info
    }

    setProductInfo(info) {
        this.info = {
            ... info
        }

        this.setQuantity(this.quantity)
        this.loaded = true

        return this
    }
}

export class PromoCode {
    constructor(data) {
        this.amount = data.amount
        this.percent = data.percent
        this.type = null
    }

    getType() {
        if (! this.type) {
            this.type = this.amount ? 'amount' : 'percent'
        }

        return this.type
    }

    getDiscount(price) {
        let discount = 0

        if (this.getType() === 'amount') {
            discount = price * this.percent / 100

            discount = Math.min(this.amount, discount)
        }
        else {
            discount = price * this.percent / 100
        }

        return roundPrice(discount)
    }
}

export function makeKey (id, options) {
    return CartItem.makeKey(id, options)
}
