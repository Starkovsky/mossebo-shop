import * as actionTypes from "./types"
import Core from "../../../../scripts/core"


export default {
    namespaced: true,

    state: {
        types: {
            default: {
                icon: 'symbol-tile',
                title: Core.translate('default')
            },

            long: {
                icon: 'symbol-list',
                title: Core.translate('long')
            },
        },

        active: 'default'
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
