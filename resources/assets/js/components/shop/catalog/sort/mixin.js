import CatalogSort from './CatalogSort'

export default {
    data() {
        return {
            sortTypes: {
                popular: 'Популярное',
                new: 'Новинки',
                discount: 'Скидки',
                name: 'Название'
            },

            activeSortType: false
        }
    },

    components: {
        CatalogSort
    },

    created() {
        this.setActiveSortType()
    },

    methods: {
        setActiveSortType(type) {
            if (type && typeof this.sortTypes[type] !== 'undefined') {
                this.activeSortType = type
            }
            else {
                this.activeSortType = Object.keys(this.sortTypes)[0]
            }
        },

        /**
         * Сортировка по популярности.
         *
         * @param products
         * @returns {Array}
         */
        sortPopular(products) {
            return _.orderBy(products, ['popular', 'id'])
        },

        /**
         * Сортировка по новинкам.
         *
         * @param products
         * @returns {Array}
         */
        sortNew(products) {
            return _.orderBy(products, ['new', 'id'])
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
            return _.orderBy(products, ['old_price', 'id'])
        },

        sortProducts(products) {
            if (! this.activeSortType) {
                return products
            }

            let methodName = 'sort' + _.upperFirst(_.camelCase(this.activeSortType))

            if (methodName in this) {
                return this[methodName]([...products])
            }

            return products
        }
    }
}
