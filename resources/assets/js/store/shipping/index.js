import * as actionTypes from './types'
import Core from '../../scripts/core'
import { LocalStorageProxy } from '../../scripts/LocalStorageProxy'
import localStorageActionsExtension from '../localStorageActionsExtension'

const defaultState = {
    ready: false,

    data: {
        name: '',
        surname: '',
        phone: '',
        email: '',
        city: '',
        address: '',
        post_code: '',
        comment: '',
    },

    types: {
        free: Core.translate('shipping.types.free'),
        express: Core.translate('shipping.types.express')
    },

    type: 'free',

    validated: false
}

export default {
    namespaced: true,

    state: {
        ... defaultState,
    },

    actions: {
        ... localStorageActionsExtension,

        init({ state, dispatch, commit }) {
            if (state.ready) return

            dispatch('initLocalStorageExtension', new LocalStorageProxy('__shipping'))

            commit(actionTypes.SHIPPING_READY)
        },

        setValue({ state, commit, dispatch }, [label, value]) {
            if (label in state.data) {
                commit(actionTypes.SHIPPING_SET_VALUE, [label, value])
                dispatch('updateLocalStorage', 'data')
            }
        },

        setType({ state, commit, dispatch }, type) {
            if (type in state.types) {
                commit(actionTypes.SHIPPING_SET_TYPE, type)
                dispatch('updateLocalStorage', 'type')
            }
        },

        validation({ commit, dispatch }, result) {
            if (result) {
                commit(actionTypes.SHIPPING_VALIDATION_SUCCESS)
            }
            else {
                commit(actionTypes.SHIPPING_VALIDATION_FAILURE)
            }

            dispatch('updateLocalStorage', 'validated')
        }
    },

    mutations: {
        [actionTypes.SHIPPING_READY](state) {
            state.ready = true
        },

        [actionTypes.SHIPPING_SET_VALUE](state, [label, value]) {
            state.data[label] = value
        },

        [actionTypes.SHIPPING_SET_TYPE](state, type) {
            state.type = type
        },

        [actionTypes.SHIPPING_VALIDATION_SUCCESS](state) {
            state.validated = true
        },

        [actionTypes.SHIPPING_VALIDATION_FAILURE](state) {
            state.validated = false
        },
    },
}
