import * as actionTypes from './types'
import Core from '../../scripts/core'
import { LocalStorageProxy } from '../../scripts/LocalStorageProxy'
import localStorageActionsExtension from '../localStorageActionsExtension'

export default {
    namespaced: true,

    state: {
        ready: false,

        cards: {
            types: {
                tile: {
                    icon: 'symbol-tile',
                    title: Core.translate('tile')
                },

                list: {
                    icon: 'symbol-list',
                    title: Core.translate('list')
                },
            },

            active: 'tile'
        }
    },

    actions: {
        ... localStorageActionsExtension,

        init({ state, dispatch, commit }) {
            if (state.ready) return

            dispatch('initLocalStorageExtension', new LocalStorageProxy('__catalog'))

            commit(actionTypes.CATALOG_READY)
        },

        setCardType({ state, commit, dispatch }, type) {
            if (type in state.cards.types) {
                commit(actionTypes.CATALOG_SET_CARD_TYPE, type)
                dispatch('updateLocalStorage', 'cards.active')
            }
        }
    },

    mutations: {
        [actionTypes.CATALOG_READY](state) {
            state.ready = true
        },

        [actionTypes.CATALOG_SET_CARD_TYPE](state, type) {
            state.cards.active = type
        },
    },
}
