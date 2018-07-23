export default class BaseFilter {
    constructor(filterData) {
        this.setFilterBaseData(filterData)
    }

    setFilterBaseData(filterData) {
        this.id = filterData.id
        this.title = filterData.title
    }

    prepare(product) {
        return product
    }
}
