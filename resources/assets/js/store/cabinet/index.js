import * as actionTypes from './types'
import Core from '../../scripts/core'
import HistoryProxy from '../../scripts/HistoryProxy'

let hp = new HistoryProxy()

export default {
    namespaced: true,

    state: {
        ready: false,

        pages: {
            orders: Core.translate('My orders'),
            profile: Core.translate('Profile'),
            reviews: Core.translate('Reviews'),
            // questions: Core.translate('Questions'),
        },

        active: 'profile'
    },

    actions: {
        init({ state, dispatch, commit }) {
            if (state.ready) return

            let hash = hp.getHash('hash')

            if (hash && hash in state.pages) {
                state.active = hash
            }

            commit(actionTypes.CATALOG_READY)
        },

        setPage({ state, commit, dispatch }, key) {
            if (key in state.pages) {
                commit(actionTypes.CATALOG_SET_PAGE, key)
                hp.setHash(key)
            }
        }
    },

    mutations: {
        [actionTypes.CATALOG_READY](state) {
            state.ready = true
        },

        [actionTypes.CATALOG_SET_PAGE](state, key) {
            state.active = key
        },
    },
}
