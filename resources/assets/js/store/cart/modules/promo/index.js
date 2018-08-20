import * as actionTypes from "./types"
import Core from "../../../../scripts/core"


export default {
    namespaced: true,

    state: {
        code: ''
    },

    actions: {
        setType({ state, commit, dispatch }, type) {
            if (type in state.types) {
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
