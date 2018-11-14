import * as actionTypes from './types'
import storageActionsExtension from '../storageActionsExtension'

export default {
    namespaced: true,

    state: {
        ids: [],
        products: [],
        category: null,
        ready: false
    },

    actions: {
        ... storageActionsExtension,

        init({ state, dispatch, commit }) {
            if (state.ready) return

            dispatch('initStorageExtension', 'comparison')
                .then(() => commit(actionTypes.COMPARISON_READY))
        },

        add({ state, dispatch, commit }, productId) {
            if (! state.ready) return

            if (state.ids.indexOf(productId) === -1) {
                commit(actionTypes.COMPARISON_SET_PRODUCT, productId)
                dispatch('updateStorage', 'ids')
            }
        },

        remove(productId) {
            if (! state.ready) return

            if (state.ids.indexOf(productId) !== -1) {
                commit(actionTypes.COMPARISON_REMOVE_PRODUCT, productId)
                dispatch('updateStorage', 'ids')
            }
        },

        setCategory({ state, commit, dispatch }, category) {
            // if (type in state.types) {
                commit(actionTypes.COMPARISON_SET_CATEGORY, category)
                dispatch('updateStorage', 'category')
            // }
        }
    },

    mutations: {
        [actionTypes.COMPARISON_READY](state) {
            state.ready = true
        },

        [actionTypes.COMPARISON_SET_PRODUCT](state, productId) {
            state.ids.push(productId)
        },

        [actionTypes.COMPARISON_REMOVE_PRODUCT](state, productId) {
            state.ids = state.ids.filter(id => id !== productId)
        },

        [actionTypes.COMPARISON_SET_CATEGORY](state, category) {
            state.category = category
        },
    },
}
