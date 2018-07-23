import BaseFilter from './BaseFilter'

export default class PriceFilter extends BaseFilter {
    constructor(filterData) {
        super(filterData)

        /*
            Максимальные значения
         */
        this.pricesRange = [
            parseInt(filterData.minPrice),
            parseInt(filterData.maxPrice)
        ]

        this.activePrices$  = false
        this.clear()
    }

    setValue(prices) {
        this.selectedRange = [
            Math.max(this.pricesRange[0], prices[0]),
            Math.min(this.pricesRange[1], prices[1]),
        ]

        this.manualRange = [... this.selectedRange]
    }

    checkProduct(product = {}) {
        let price = parseInt(product.price)

        return price >= this.manualRange[0] && price <= this.manualRange[1]
    }

    prepareActiveOptions(product) {
        if (! this.activePrices$) {
            this.activePrices$ = [
                product.price,
                product.price
            ]
        }
        else {
            if (product.price < this.activePrices$[0]) {
                this.activePrices$[0] = product.price
            }
            else if (product.price > this.activePrices$[1]) {
                this.activePrices$[1] = product.price
            }
        }
    }

    applyActiveOptions(filterId) {
        let prices = this.activePrices$ ? this.activePrices$ : this.pricesRange

        this.availableRange = [... prices]

        if (filterId !== this.id) {
            this.selectedRange = [
                Math.max(prices[0], this.manualRange[0]),
                Math.min(prices[1], this.manualRange[1]),
            ]
        }

        this.activePrices$ = false
    }

    isDirty() {
        return ! _.isEqual(this.selectedRange, this.pricesRange)
    }

    clear() {
        /*
            Выбранные пользователем цены
         */
        this.selectedRange = [
            ... this.pricesRange
        ]

        /*
            Доступные для выбора цены
         */
        this.availableRange = [
            ... this.pricesRange
        ]


        /*
            Range, который установил пользователь
         */
        this.manualRange = [
            ... this.pricesRange
        ]
    }
}
