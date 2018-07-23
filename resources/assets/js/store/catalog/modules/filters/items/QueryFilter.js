import BaseFilter from './BaseFilter'
import Core from '../../../../../scripts/core'

export default class QueryFilter extends BaseFilter {
    constructor(filterData) {
        super(filterData)
        this.indexData = filterData.indexData

        let query = Core.getParameterByName('q')

        if (query) {
            this.setValue(query)
        }
        else {
            this.query = ''
            this.workingQuery = ''
        }
    }

    setValue(query) {
        this.query = query
        this.workingQuery = QueryFilter.cleanString(this.query)

        Core.history.replace(Core.updateQueryStringParameter(window.location.href, 'q', this.query))
    }

    static cleanString(string) {
        return string.toLowerCase().replace(/[^a-zа-я]/gi, ' ').replace(/\s\s+/g, ' ')
    }

    checkProduct(product = {}) {
        let queryParts = this.workingQuery.split(' ')

        for (let i = 0; i < queryParts.length; i++) {
            if (product.queryIndex.indexOf(queryParts[i]) === -1) {
                return false
            }
        }

        return true
    }

    prepare(product) {
        product.queryIndex = [product.name]

        let searchTitle = (data, id, index) => {
            for (let i = 0; i < data.length; i++) {
                if ('options' in data[i]) {
                    searchTitle(data[i].options, id, index)
                }
                else if (data[i].id === id) {
                    index.push(data[i].title)
                    break
                }
            }
        }

        for (let key in this.indexData) {
            if (! (key in product)) continue

            if (_.isArray(product[key])) {
                product[key].forEach(id => {
                    searchTitle(this.indexData[key], id, product.queryIndex)
                })
            }
        }

        product.queryIndex = QueryFilter.cleanString(product.queryIndex.join(' '))
    }

    prepareActiveOptions(product) {}

    applyActiveOptions(filterId) {}

    isDirty() {
        return false
    }

    clear() {
    }
}
