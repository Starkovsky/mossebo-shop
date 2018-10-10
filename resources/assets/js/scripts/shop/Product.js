import Sale from './Sale'

export default class Product {
    constructor(productData) {
        if (productData instanceof Product) {
            return productData
        }

        for (let i in productData) {
            if (productData.hasOwnProperty(i)) {
                this[i] = productData[i]
            }
        }

        if (this.hasSale()) {
            this.sale = new Sale(this.sale)
        }

        let badges = this.badges || []

        this.popular = badges.indexOf(1) !== -1
        this.new = badges.indexOf(6) !== -1
    }

    getMinPrice() {
        return this.hasSale() && this.sale.isActual() ? this.sale.getPrice() : this.price
    }

    getMaxPrice() {
        return this.old_price ? this.old_price : this.price
    }

    getDiscount() {
        return this.getMaxPrice() - this.getMinPrice()
    }

    getDiscountPercent() {
        let maxPrice = this.getMaxPrice()

        if (! maxPrice) {
            return 0
        }

        return Math.round(this.getDiscount() / maxPrice * 100)
    }

    hasSale() {
        return 'sale' in this
    }
}
