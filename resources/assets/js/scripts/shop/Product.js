import Sale from './Sale'

export default class Product {
    constructor(productData) {
        for (let i in productData) {
            if (productData.hasOwnProperty(i)) {
                this[i] = productData[i]
            }
        }

        if (this.hasSale()) {
            this.sale = new Sale(this.sale)
        }
    }

    hasSale() {
        return 'sale' in this
    }
}
