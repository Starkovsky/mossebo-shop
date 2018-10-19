import * as actionTypes from './types'
import Core from '../../scripts/core'
import storageActionsExtension from '../storageActionsExtension'

export default {
    namespaced: true,

    state: {
        ready: false,

        data: {
            first_name:   Core.config('user.first_name') || '',
            last_name:    Core.config('user.last_name') || '',
            phone:        Core.config('user.phone') || '',
            email:        Core.config('user.email') || '',
            // address:      Core.config('user.address') || '',
            city:         '',
            street:       '',
            house_number: '',
            apartment:    '',
            floor:        '',
            entrance:     '',
            intercom:     '',
            post_code:    Core.config('user.post_code') || '',
            comment:      '',
        },

        // todo: Перенести тип
        types: {
            '1': Core.translate('shipping.types.free'),
            '2': Core.translate('shipping.types.express')
        },

        type: '1',

        validated: false
    },

    actions: {
        ... storageActionsExtension,

        init({ state, rootState, dispatch, commit }) {
            if (state.ready) return

            dispatch('initStorageExtension', 'shipping')
                .then(() => {
                    let city = state.data.city

                    if (! city) {
                        city = rootState.city.name
                    }

                    if (! city) {
                        city = Core.config('user.city')
                    }

                    state.data.city = city

                    commit(actionTypes.SHIPPING_READY)
                })
        },

        setValue({ state, commit, dispatch }, [label, value]) {
            if (label in state.data) {
                commit(actionTypes.SHIPPING_SET_VALUE, [label, value])
                dispatch('updateStorage', 'data')
            }
        },

        setType({ state, commit, dispatch }, type) {
            if (type in state.types) {
                commit(actionTypes.SHIPPING_SET_TYPE, type)
                dispatch('updateStorage', 'type')
            }
        },

        validation({ commit, dispatch }, result) {
            if (result) {
                commit(actionTypes.SHIPPING_VALIDATION_SUCCESS)
            }
            else {
                commit(actionTypes.SHIPPING_VALIDATION_FAILURE)
            }

            dispatch('updateStorage', 'validated')
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
            state.type = type.toString()
        },

        [actionTypes.SHIPPING_VALIDATION_SUCCESS](state) {
            state.validated = true
        },

        [actionTypes.SHIPPING_VALIDATION_FAILURE](state) {
            state.validated = false
        },
    },
}
