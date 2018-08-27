import * as actionTypes from "./types"
import Core from '../../../../scripts/core'

const defaultState = {
    id: 0,
    name: '',
    percent: 0,
    amount: 0,
    type: '',
    title: '',
    description: '',
    hasError: false,
}

function setPromo(state, promoCode) {
    for (let i in defaultState) {
        if (i in promoCode) {
            state[i] = promoCode[i]
        }
        else {
            state[i] = defaultState[i]
        }
    }
}

export default {
    namespaced: true,

    state: {
        ... defaultState,

        ready: false
    },

    actions: {
        apply({ state, commit }, promoCode) {
            if (Core.canUsePromo()) {
                return commit(actionTypes.CART_PROMO_APPLY, promoCode)
            }
        },

        error({ state, commit }, promoCode) {
            if (Core.canUsePromo()) {
                return commit(actionTypes.CART_PROMO_ERROR, promoCode)
            }
        },

        clear({commit}) {
            commit(actionTypes.CART_PROMO_CLEAR)
        }
    },

    mutations: {
        [actionTypes.CART_PROMO_APPLY](state, promoCode) {
            setPromo(state, promoCode)
        },

        [actionTypes.CART_PROMO_ERROR](state, promoCode) {
            setPromo(state, promoCode)
            state.hasError = true
        },

        [actionTypes.CART_PROMO_CLEAR](state) {
            for (let i in defaultState) {
                state[i] = defaultState[i]
            }
        },
    },

    getters: {
        exist(state) {
            return state.id !== 0
        },

        accepted(state, getters) {
            return !state.hasError && getters.exist
        },

        type(state) {
            return state.amount ? 'amount' : 'percent'
        }
    }
}
