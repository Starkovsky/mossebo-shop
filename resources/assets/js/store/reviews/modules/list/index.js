import * as actionTypes from './types'
import axios from "axios/index"
import SortModule from './modules/sort'

export default {
    modules: {
        sort: SortModule
    },

    namespaced: true,

    state: {
        url: '',
        all: false,
        reviews: [],
        loading: false,
        error: false,
        abortRequest: false
    },

    actions: {
        init({state, dispatch}, url) {
            return dispatch('sort/init')
                .then(() => dispatch('setUrl', url))
                .then(() => dispatch('fetch'))
        },

        destroy({state}) {
            if (state.loading && _.isFunction(state.abortRequest)) {
                state.abortRequest()
            }
        },

        reFetch({state, dispatch}) {
            if (state.loading && _.isFunction(state.abortRequest)) {
                state.abortRequest()
            }

            return dispatch('fetch')
        },

        fetch({state, dispatch, commit}) {
            commit(actionTypes.REVIEWS_LIST_REQUEST_START)

            return axios.get(state.url, {
                cancelToken: new axios.CancelToken(c => state.abortRequest = c)
            })
                .then(response => {
                    dispatch('setSortedReviews', response.data.reviews)
                })
                .catch(thrown => {
                    if (! axios.isCancel(thrown)) {
                        commit(actionTypes.REVIEWS_LIST_ERROR)
                    }
                })
                .finally(() => {
                    commit(actionTypes.REVIEWS_LIST_REQUEST_END)
                })
        },

        setUrl({state}, url) {
            state.url = url || window.location.origin + window.location.pathname + '/reviews'
        },

        setSortedReviews({state, commit}, reviews) {
            reviews = reviews || state.reviews

            if (state.sort.active === 'useful') {
                reviews = reviews.sort((a, b) => {
                    let diff = b.likes.likes - b.likes.dislikes - a.likes.likes + a.likes.dislikes
                    return diff === 0 ? b.created - a.created : diff
                })
            }
            else if (state.sort.active === 'new') {
                reviews = reviews.sort((a, b) => b.created - a.created)
            }

            commit(actionTypes.REVIEWS_LIST_SET_LIST, reviews)
        },

        setSortType({state, dispatch}, type) {
            dispatch('sort/setType', type)
                .then(() => dispatch('setSortedReviews'))
        },

        all({state, commit}) {
            if (! state.all) {
                commit(actionTypes.REVIEWS_LIST_All)
            }
        },

        loading({commit}) {
            commit(actionTypes.REVIEWS_LIST_LOADING_START)
        }
    },

    mutations: {
        [actionTypes.REVIEWS_LIST_REQUEST_START](state) {
            state.error = false
            state.loading = true
        },

        [actionTypes.REVIEWS_LIST_LOADING_START](state) {
            state.loading = true
        },

        [actionTypes.REVIEWS_LIST_ERROR](state) {
            state.error = true
        },

        [actionTypes.REVIEWS_LIST_SET_LIST](state, reviews) {
            state.reviews = reviews
        },

        [actionTypes.REVIEWS_LIST_REQUEST_END](state) {
            state.loading = false
            state.abortRequest = false
        },

        [actionTypes.REVIEWS_LIST_All](state) {
            state.all = true
        },
    }
}
