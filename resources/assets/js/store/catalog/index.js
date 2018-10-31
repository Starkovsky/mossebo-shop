import * as actionTypes from './types'
import storageActionsExtension from '../storageActionsExtension'
import Product from '../../scripts/shop/Product'
import Request from '../../scripts/Request'
import FilterModule from './modules/filters'
import SortModule from './modules/sort'
import CardsModule from './modules/cards'
import PaginateModule from './modules/pagination'
import SearchModule from './modules/search'
import { makeLoader } from '../../scripts/PendingLoader'

export default {
    namespaced: true,

    modules: {
        filters:    FilterModule,
        sort:       SortModule,
        cards:      CardsModule,
        pagination: PaginateModule,
        search:     SearchModule
    },

    state: {
        error: false,
        loading: false,
        filtering: false,
        filteringPendingLoader: null,

        products: [],
        activeProductIndexes: [],
        initialized: false,
        ready: false,

        searchTimeout: null
    },

    actions: {
        ... storageActionsExtension,

        init({ state, dispatch, commit }, params) {
            if (state.ready) return

            state.filteringPendingLoader = makeLoader(
                () => commit(actionTypes.CATALOG_FILTERING_START),
                () => commit(actionTypes.CATALOG_FILTERING_END),
                300
            )

            dispatch('initStorageExtension', 'catalog')
                .then(() => dispatch('sort/init', params.sort))
                .then(() => dispatch('pagination/init'))
                .then(() => dispatch('search/init'))
                .then(() => dispatch('filters/init', params.filters))
                .then(() => dispatch('fetchCatalog'))
        },

        fetchCatalog({state, commit, dispatch}) {
            commit(actionTypes.CATALOG_REQUEST_START)

            Promise.all([dispatch('fetchProducts'), dispatch('filters/fetchFilters')])
                .then(response => {
                    dispatch('filters/makeFilters', response[0])
                        .then(([products, filters]) => {
                            commit(actionTypes.CATALOG_REQUEST_SUCCESS)

                            dispatch('filters/setFilters', filters)
                                .then(() => dispatch('setProducts', products))
                                .then(() => dispatch(
                                    'filters/calculateProductCountPerOption',
                                    state.products
                                ))
                                .then(() => dispatch('process', 'sort'))
                                .then(() => commit(actionTypes.CATALOG_READY))
                        })
                })
                .catch((error) => {
                    commit(actionTypes.CATALOG_REQUEST_FAILURE)

                    console.error(error)
                })
        },

        fetchProducts({state, commit}) {
            if (state.searchRequest) {
                state.searchRequest.abort()
            }

            return new Promise(resolve => {
                state.searchRequest = new Request('get', '/api' + window.location.pathname + window.location.search)
                    .success(response => {
                        state.searchRequest = null
                        resolve(response.data.products.map(product => new Product(product)))
                    })
                    .fail(() => commit(actionTypes.CATALOG_REQUEST_FAILURE))
                    .start()
            })
        },

        setProducts({commit}, products) {
            commit(actionTypes.CATALOG_SET_PRODUCTS, products)
        },

        setActiveProductIndexes({commit}, activeProductIndexes) {
            commit(actionTypes.CATALOG_SET_ACTIVE_PRODUCT_INDEXES, activeProductIndexes)
        },

        setCardType({ state, commit, dispatch }, type) {
            if (! state.filtering && type !== state.cards.active) {
                dispatch('cards/setType', type)
                    .then(() => dispatch('updateStorage', 'cards.active'))
                    .then(() => dispatch('process', 'paginate'))
            }
        },

        setFilterValue({state, dispatch}, value) {
            if (! state.filtering) {
                dispatch('filters/setValue', value)
                    .then(() => dispatch('process', 'filter'))
            }
        },

        clearFilters({state, dispatch}) {
            if (! state.filtering) {
                dispatch('filters/clear')
                    .then(() => dispatch('process', 'filter'))
            }
        },

        setSortType({state, dispatch}, type) {
            if (! state.filtering) {
                dispatch('sort/setType', type)
                    .then(() => dispatch('process', 'sort'))
            }
        },

        more({state, dispatch}) {
            if (! state.filtering) {
                dispatch('pagination/more')
                    .then(() => dispatch('pagination/paginate'))
            }
        },

        setSearchQuery({state, dispatch}, value) {
            clearTimeout(state.searchTimeout)

            dispatch('search/setQuery', value)
                .then(() => new Promise(resolve => {
                    state.searchTimeout = setTimeout(() => {
                        resolve()
                    }, 1000)
                }))
                .then(() => dispatch('forceSearch'))
        },

        forceSearch({state, dispatch}) {
            clearTimeout(state.searchTimeout)

            dispatch('process', 'search')
        },

        process({state, dispatch, commit}, needToDo) {
            let queue = dispatch('filteringStart')
                .then(() => dispatch('pagination/toStart'))

            let steps = ['search', 'sort', 'filter', 'paginate']
            let queueSteps = steps.splice(steps.indexOf(needToDo))

            if (queueSteps.indexOf('search') !== -1) {
                queue = queue.then(() => {
                    return dispatch('fetchProducts')
                        .then(products => dispatch('filters/makeFilters', products)
                            .then(([products, filters]) => {
                                return dispatch('filters/setFilters', filters)
                                    .then(() => dispatch('setProducts', products))
                                    .then(() => dispatch(
                                        'filters/calculateProductCountPerOption',
                                        state.products
                                    ))
                            }))
                })
            }

            if (queueSteps.indexOf('sort') !== -1) {
                queue = queue.then(() => {
                    return dispatch('sort/sort', state.products)
                        .then(products => dispatch('setProducts', products))
                })
            }

            if (queueSteps.indexOf('filter') !== -1) {
                queue = queue.then(() => {
                    return dispatch('filters/filter', state.products)
                        .then(indexes => {
                            dispatch('setActiveProductIndexes', indexes)
                                .then(() => dispatch('filters/applyActiveOptions', indexes.map(index => state.products[index])))
                        })
                })
            }

            if (queueSteps.indexOf('paginate') !== -1) {
                queue = queue.then(() => dispatch('pagination/paginate'))
            }

            queue.then(() => dispatch('filteringEnd'))

            queue.catch(e => {
                console.log(e)
                commit(actionTypes.CATALOG_REQUEST_FAILURE)
            })
        },

        filteringStart({state}) {
            if (state.filteringPendingLoader.loading) {
                console.log('filtering break')
                console.timeEnd('filtering')
            }

            state.filteringPendingLoader.start()
            console.time('filtering')
        },

        filteringEnd({state}) {
            state.filteringPendingLoader.finish()
            console.timeEnd('filtering')
        }
    },

    mutations: {
        [actionTypes.CATALOG_READY](state) {
            console.log('ready')
            state.ready = true
        },

        [actionTypes.CATALOG_REQUEST_START](state) {
            state.loading = true
        },

        [actionTypes.CATALOG_REQUEST_SUCCESS](state) {
            state.loading = false
            state.error = false
        },

        [actionTypes.CATALOG_REQUEST_FAILURE](state) {
            state.loading = false
            state.error = true
        },

        [actionTypes.CATALOG_SET_PRODUCTS](state, products) {
            state.products = products
        },

        [actionTypes.CATALOG_SET_ACTIVE_PRODUCT_INDEXES](state, indexes) {
            state.activeProductIndexes = indexes
        },

        [actionTypes.CATALOG_FILTERING_START](state) {
            state.filtering = true
        },

        [actionTypes.CATALOG_FILTERING_END](state) {
            state.filtering = false
        }
    }
}
