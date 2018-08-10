import * as actionTypes from './types'
import storageActionsExtension from '../storageActionsExtension'
import { CookieStorageProxy } from '../../scripts/storage/CookieStorageProxy'
import Core from "../../scripts/core"

export default {
    namespaced: true,

    state: {
        ready: false,
        id: null,
        name: null,
        selected: false,
        query: ''
    },

    actions: {
        ... storageActionsExtension,

        init({ state, dispatch, commit }) {
            if (state.ready) return

            dispatch('initStorageExtension', 'city')
                .then(() => {
                    let currentCity =  Core.config('location.city')

                    if (typeof currentCity === 'object' && 'id' in currentCity && 'name' in currentCity) {
                        state.id = currentCity.id
                        state.name = currentCity.name
                    }

                    commit(actionTypes.CITY_READY)
                })
        },

        setCity({ state, commit, dispatch }, city) {
            commit(actionTypes.CITY_SET, city)
            commit(actionTypes.CITY_SET_QUERY, '')
            dispatch('updateStorage', ['id', 'selected'])
        },

        setQuery({ state, commit }, query) {
            commit(actionTypes.CITY_SET_QUERY, query)
        },

        confirmCity({ state, commit, dispatch }) {
            commit(actionTypes.CITY_CONFIRM)
            dispatch('updateStorage', ['id', 'selected'])
        },

        setStorageProxy({ state }) {
            state.storageProxy = new CookieStorageProxy('__' + state.storageNamespace)
        },
    },

    mutations: {
        [actionTypes.CITY_READY](state) {
            state.ready = true
        },

        [actionTypes.CITY_SET](state, city) {
            state.id = city.id
            state.name = city.name
        },

        [actionTypes.CITY_CONFIRM](state) {
            state.selected = true
        },

        [actionTypes.CITY_SET_QUERY](state, query) {
            state.query = query
        }
    },
}
