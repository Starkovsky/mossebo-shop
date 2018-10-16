export default class PromoCode {
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

        return Math.round(discount)
    }
}
