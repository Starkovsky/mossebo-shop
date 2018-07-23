import * as actionTypes from "./types"
import PendingLoader, {makeLoader} from '../../../../scripts/PendingLoader'

export default {
    namespaced: true,

    state: {
        page: 1,
        perPage: 24,
        perPageSet: [24, 48],
        productsToShow: [],
        loading: false,
        paginationLoader: null,
    },

    actions: {
        init({state, commit}) {
            state.paginationLoader = makeLoader(
                () => commit(actionTypes.CATALOG_PAGINATION_LOADING_START),
                products => {
                    commit(actionTypes.CATALOG_PAGINATION_SET_PRODUCTS, products)
                    commit(actionTypes.CATALOG_PAGINATION_LOADING_END)
                },
                128
            )
        },

        paginate({state, rootState, commit, dispatch}) {
            dispatch('loadingStart')

            let products = rootState.catalog.products
            let indexes = rootState.catalog.activeProductIndexes

            let end = Math.min(state.perPage * state.page, indexes.length)

            dispatch('loadingEnd', indexes.slice(0, end).map(index => products[index]))
        },

        setPage({state, commit}, page) {
            if (page > 0 && state.page !== page) {
                commit(actionTypes.CATALOG_PAGINATION_SET_PAGE, page)
            }
        },

        setPerPage({state, commit}, perPage) {
            if (perPage !== state.perPage && state.perPageSet.indexOf(perPage) !== -1) {
                commit(actionTypes.CATALOG_PAGINATION_SET_PER_PAGE, perPage)
            }
        },

        toStart({dispatch}) {
            return dispatch('setPage', 1)
        },

        more({state, dispatch}) {
            return dispatch('setPage', state.page + 1)
        },

        loadingStart({state}) {
            state.paginationLoader.start()
            console.time('pagination')
        },

        loadingEnd({state}, products) {
            state.paginationLoader.finish(products)
            console.timeEnd('pagination')
        }
    },

    mutations: {
        [actionTypes.CATALOG_PAGINATION_SET_PRODUCTS](state, products) {
            state.productsToShow = products
        },

        [actionTypes.CATALOG_PAGINATION_SET_PAGE](state, page) {
            state.page = page
        },

        [actionTypes.CATALOG_PAGINATION_SET_PER_PAGE](state, perPage) {
            state.perPage = perPage
        },

        [actionTypes.CATALOG_PAGINATION_LOADING_START](state) {
            state.loading = true
        },

        [actionTypes.CATALOG_PAGINATION_LOADING_END](state) {
            state.loading = false
        }
    }
}
