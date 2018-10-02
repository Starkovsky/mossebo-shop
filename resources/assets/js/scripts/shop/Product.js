import SaleTime from './SaleTime'

export default class Product {
    constructor(productData) {
        for (let i in productData) {
            if (productData.hasOwnProperty(i)) {
                this[i] = productData[i]
            }
        }

        if (this.hasSale()) {
            this.sale = new SaleTime(this.sale)
        }
    }

    hasSale() {
        return 'sale' in this
    }
}
