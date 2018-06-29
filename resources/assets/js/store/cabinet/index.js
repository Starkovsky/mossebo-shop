import * as actionTypes from './types'
import Core from '../../scripts/core'
import { LocalStorageProxy } from '../../scripts/LocalStorageProxy'
import localStorageActionsExtension from '../localStorageActionsExtension'

export default {
    namespaced: true,

    state: {
        ready: false,

        pages: {
            orders: Core.translate('Orders'),
            profile: Core.translate('Profile'),
            reviews: Core.translate('Reviews'),
            questions: Core.translate('Questions'),
        },

        activePage: null
    },

    actions: {
        ... localStorageActionsExtension,

        init({ state, dispatch, commit }) {
            if (state.ready) return

            let pathname = window.location.pathname.split('/')
            let key = pathname[pathname.length - 1]

            if (key in state.pages) {
                state.activePage = key
            }

            dispatch('initLocalStorageExtension', new LocalStorageProxy('__cabinet'))

            commit(actionTypes.CATALOG_READY)
        },

        setPage({ state, commit, dispatch }, key) {
            if (key in state.pages) {
                commit(actionTypes.CATALOG_SET_PAGE, key)
            }
        }
    },

    mutations: {
        [actionTypes.CATALOG_READY](state) {
            state.ready = true
        },

        [actionTypes.CATALOG_SET_PAGE](state, key) {
            state.activePage = key
        },
    },
}
