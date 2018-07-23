import BaseOptionsFilter from './BaseOptionsFilter'

export default class MainFilter extends BaseOptionsFilter {
    prepare(product) {
        if (! ('filterOptions' in product)) {
            product.filterOptions = {}
        }

        product.filterOptions[this.id] = product[this.id]
    }
}
