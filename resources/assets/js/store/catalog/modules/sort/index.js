import * as actionTypes from './types'

const sortMethods = {
    /**
     * Сортировка по популярности.
     *
     * @param products
     * @returns {Array}
     */
    sortPopular(products) {
        return _.orderBy(products, ['popular', 'showed', 'id'], ['desc', 'desc', 'asc'])
    },

    sortCheaper(products) {
        return products.sort((a, b) => a.getPrice() - b.getPrice())
    },

    sortExpensive(products) {
        return products.sort((a, b) => b.getPrice() - a.getPrice())
    },

    /**
     * Сортировка по новинкам.
     *
     * @param products
     * @returns {Array}
     */
    sortNew(products) {
        return _.orderBy(products, ['new', 'id'], ['desc', 'desc'])
    },

    /**
     * Сортировка по названию.
     *
     * @param products
     * @returns {Array}
     */
    sortName(products) {
        return _.orderBy(products, ['name', 'id'])
    },

    /**
     * Сортировка по скидке.
     *
     * @param products
     * @returns {Array}
     */
    sortDiscount(products) {
        return products.sort((a, b) => {
            let result = b.getDiscountPercent() - a.getDiscountPercent()

            if (result === 0) {
                return a.id - b.id
            }

            return result
        })
    }
}

export default {
    namespaced: true,

    state: {
        types: {
            popular:   'Популярное',
            cheaper:   'Сначала дешевле',
            expensive: 'Сначала дороже',
            discount:  'Со скидками',
            new:       'Новинки',
        },

        active: 'popular'
    },

    actions: {
        sort({state}, products) {
            if (! state.active) {
                return products
            }

            let methodName = 'sort' + _.upperFirst(_.camelCase(state.active))

            if (methodName in sortMethods) {
                return sortMethods[methodName](products)
            }

            return products
        },

        setType({state, commit}, type) {
            if (type && typeof state.types[type] !== 'undefined') {
                commit(actionTypes.CATALOG_SET_SORT, type)
            }
        },
    },

    mutations: {
        [actionTypes.CATALOG_SET_SORT](state, sort) {
            state.active = sort
        }
    }
}
