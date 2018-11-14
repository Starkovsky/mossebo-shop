import BaseOptionsFilter from './BaseOptionsFilter'

export default class AttributesFilter extends BaseOptionsFilter {
    init(filterData) {
        this.id = filterData.id
        this.title = filterData.title
        this.position = filterData.position
        this.options = filterData.options
    }


    prepare(product) {
        if (! ('filterOptions' in product)) {
            product.filterOptions = {}
        }

        product.filterOptions[this.id] = this.optionIds.filter(id => product.attributes.indexOf(id) !== -1)
    }
}
