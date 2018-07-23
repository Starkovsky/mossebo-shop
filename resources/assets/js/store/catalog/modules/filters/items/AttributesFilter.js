import BaseOptionsFilter from './BaseOptionsFilter'

export default class AttributesFilter extends BaseOptionsFilter {
    init(filterData, existingOptionIds) {
        this.id = filterData.id
        this.title = filterData.title
        this.position = filterData.position
        this.options = _.orderBy(filterData.options.filter(option => existingOptionIds.indexOf(option.id) !== -1), 'position')
    }


    prepare(product) {
        if (! ('filterOptions' in product)) {
            product.filterOptions = {}
        }

        product.filterOptions[this.id] = this.optionIds.filter(id => product.attributes.indexOf(id) !== -1)
    }
}
