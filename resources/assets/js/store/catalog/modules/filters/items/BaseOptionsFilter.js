import BaseFilter from './BaseFilter'

export default class BaseOptionsFilter extends BaseFilter {
    constructor(filterData) {
        super(filterData)

        this.setOptions(filterData.options)

        this.checkedOptions = []
        this.activeOptions  = []
        this.activeOptions$ = {}
    }

    setOptions(options = []) {
        this.options = _.orderBy(options, 'position').reduce((acc, option) => {
            option.counter = 0
            acc[option.id] = option

            return acc
        }, {})

        this.optionIds = options.map(option => option.id)
    }

    setValue(optionId) {
        optionId = parseInt(optionId)

        if (this.optionIds.indexOf(optionId) === -1) {
            return false
        }

        if (this.checkedOptions.indexOf(optionId) === -1) {
            this.checkedOptions.push(optionId)
        }
        else {
            this.checkedOptions = this.checkedOptions.filter(id => id !== optionId)
        }

        return true
    }

    checkProduct(product) {
        if (! product) return false

        if (this.checkedOptions.length === 0) {
            return true
        }

        return this.checkProductOptions(
            this.getProductOptions(product)
        )
    }

    getProductOptions(product) {
        if ('filterOptions' in product) {
            if (this.id in product.filterOptions) {
                return product.filterOptions[this.id]
            }
        }

        return []
    }

    checkProductOptions(options) {
        if (! options) return false

        for (let i = 0; i < this.checkedOptions.length; i++) {
            if (options.indexOf(this.checkedOptions[i]) !== -1) {
                return true
            }
        }

        return false
    }

    prepareActiveOptions(product) {
        this.getProductOptions(product).forEach(optionId => {
            this.activeOptions$[optionId] = 1
        })
    }

    applyActiveOptions() {
        this.activeOptions = Object.keys(this.activeOptions$).map(optionId => parseInt(optionId))

        this.activeOptions$ = {}
    }

    addProductToCount(product) {
        this.getProductOptions(product).forEach(optionId => {
            if (this.checkProduct(product)) {
                this.options[optionId].counter++
            }
        })
    }

    applyProductCount() {
        for (let i in this.options) {
            this.options[i].productCount = this.options[i].counter
            this.options[i].counter = 0
        }
    }

    activeOptions$ToDefault() {
        this.activeOptions$ = this.optionIds.reduce((acc, id) => {
            acc[id] = 0

            return acc
        }, {})
    }

    clear() {
        this.checkedOptions = []
    }

    isDirty() {
        return !!this.checkedOptions.length
    }
}
