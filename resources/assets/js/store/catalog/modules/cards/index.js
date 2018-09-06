import * as actionTypes from "./types"
import Core from "../../../../scripts/core"


export default {
    namespaced: true,

    state: {
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
    },

    actions: {
        setType({ state, commit, dispatch }, type) {
            if (type in state.types && state.active !== type) {
                commit(actionTypes.CATALOG_SET_CARD_TYPE, type)
            }
        },
    },

    mutations: {
        [actionTypes.CATALOG_SET_CARD_TYPE](state, type) {
            state.active = type
        },
    }
}
