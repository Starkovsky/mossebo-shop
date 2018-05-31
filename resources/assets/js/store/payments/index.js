import * as actionTypes from './types'
import Core from '../../scripts/core'
import { LocalStorageProxy } from '../../scripts/LocalStorageProxy'
import localStorageActionsExtension from '../localStorageActionsExtension'

const defaultState = {
    ready: false,

    types: {
        'yandex_payment': {
            title: Core.translate('payments.yandex_payment.title'),
            image: {
                src: '/assets/images/payments/yandex_payment.png',
                srcset: '/assets/images/payments/yandex_payment@2x.png'
            }
        },
        'upon_receipt': {
            title: Core.translate('payments.upon_receipt.title'),
            infoTitle: Core.translate('payments.upon_receipt.info_title'),
        }
    },

    type: 'yandex_payment'
}

export default {
    namespaced: true,

    state: {
        ... defaultState
    },

    actions: {
        ... localStorageActionsExtension,

        init({ state, dispatch, commit }) {
            if (state.ready) return

            dispatch('initLocalStorageExtension', new LocalStorageProxy('__payment'))

            commit(actionTypes.PAYMENTS_READY)
        },

        setType({ state, commit, dispatch }, type) {
            if (type in state.types) {
                commit(actionTypes.PAYMENTS_SET_TYPE, type)
                dispatch('updateLocalStorage', 'type')
            }
        }
    },

    mutations: {
        [actionTypes.PAYMENTS_READY](state) {
            state.ready = true
        },

        [actionTypes.PAYMENTS_SET_TYPE](state, type) {
            state.type = type
        },
    },

    getters: {
        payment({payment}) {

        }
    }
}
