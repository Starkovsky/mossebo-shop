import BaseFilter from './items/BaseFilter'
import MainFilter from './items/MainFilter'
import AttributesFilter from './items/AttributesFilter'
import PriceFilter from "./items/PriceFilter";
import DataHandler from '../../../../scripts/DataHandler'
import Core from '../../../../scripts/core/index'

let mainFilterTypes = ['categories', 'styles', 'rooms']



function prepareOptions(options, exstingsIds) {
    let result =  options.filter(option => exstingsIds.indexOf(option.id) !== -1)
    result = _.orderBy(result, 'position')

    return result
}

/*
    Создает фильтр по основным свойствам товара
 */
function mainFilterMaker(key, exstingsIds = []) {
    return new Promise(resolve => {
        DataHandler.get(key)
            .then(data => {
                let options = prepareOptions(data[key], exstingsIds)

                if (options.length > 1) {
                    resolve(new MainFilter({
                        id: key,
                        title: Core.translate('filters.main.' + key),
                        options
                    }))
                }
                else {
                    resolve()
                }
            })
    })
}

/*
    Создает фильтрЫ по аттрибутам товара
 */
function attributeFiltersMaker(exstingsIds = []) {
    return new Promise(resolve => {
        DataHandler.get('attributes')
            .then(data => {
                if (! data.attributes) {
                    return
                }

                let filters = _.orderBy(data.attributes, 'position').reduce((acc, attribute) => {
                    let options = prepareOptions(attribute.options, exstingsIds)

                    if (options.length > 1) {
                        acc.push(new AttributesFilter({
                            ... attribute,
                            options
                        }))
                    }

                    return acc
                }, [])

                resolve(filters)
            })
    })
}

/*
    Создает фильтр по цене
 */
function priceFilterMaker(minPrice, maxPrice) {
    return new Promise(resolve => {
        resolve(new PriceFilter({
            id: 'prices',
            title: Core.translate('filters.price'),
            minPrice,
            maxPrice
        }))
    })
}

function getOptionsCollector(key, maker) {
    let ids = {}

    return {
        set: product => {
            if (!(key in product && product[key])) return

            if (product[key] instanceof Array) {
                product[key].forEach(id => {
                    ids[id] = 1
                })
            }
            else {
                ids[product[key]] = 1
            }
        },

        get: () => {
            return maker(Object.keys(ids).map(id => parseInt(id)))
        }
    }
}

function getPriceCollector(maker) {
    let min = 999999999
    let max = 0

    return {
        set: product => {
            if (product.price < min) {
                min = product.price
            }

            if (product.price > max) {
                max = product.price
            }
        },

        get: () => {
            return maker(min, max)
        }
    }
}

function getHandler(types) {
    let collectors = []

    if (types.indexOf('prices') !== -1) {
        collectors.push(getPriceCollector(priceFilterMaker))
    }

    mainFilterTypes.forEach(type => {
        if (types.indexOf(type) !== -1) {
            collectors.push(getOptionsCollector(type, ids => mainFilterMaker(type, ids)))
        }
    })

    if (types.indexOf('attributes') !== -1) {
        collectors.push(getOptionsCollector('attributes', attributeFiltersMaker))
    }

    return {
        collect: product => {
            collectors.forEach(collector => collector.set(product))
        },

        make: () => {
            return collectors.reduce((acc, collector) => {
                let promises = collector.get()

                if (_.isArray(promises)) {
                    acc = [
                        ... acc,
                        ... promises
                    ]
                }
                else if (promises) {
                    acc.push(promises)
                }

                return acc
            }, [])
        }
    }
}

export default function makeFilters(products = [], types = {}) {
    console.time('making filters')

    let handler = getHandler(types)

    products.reduce((acc, product) => {
        handler.collect(product)
    }, {})

    return new Promise(resolve => {
        Promise.all(handler.make())
            .then(data => {
                let filters = data.reduce((acc, item) => {
                    if (_.isArray(item)) {
                        acc = [
                            ... acc,
                            ... item
                        ]
                    }
                    else if (item instanceof BaseFilter) {
                        acc.push(item)
                    }

                    return acc
                }, [])

                products = [... products]

                filters.forEach(filter => {
                    products.forEach(product => filter.prepare(product))
                }, [])

                console.timeEnd('making filters')

                resolve([products, filters])
            })
    })
}
