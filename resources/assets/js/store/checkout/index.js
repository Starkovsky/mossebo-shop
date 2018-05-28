import * as actionTypes from './types'
import Core from '../../scripts/core'

export default {
    namespaced: true,

    state: {
        steps: [
            {
                identif: 'cart',
                icon: 'symbol-cart',
                stepName: 'Шаг первый',
                title: 'Корзина',
            },

            {
                identif: 'shipping',
                icon: 'symbol-truck',
                stepName: 'Шаг второй',
                title: 'Доставка',
            },

            {
                identif: 'payment',
                icon: 'symbol-credit-card',
                stepName: 'Шаг третий',
                title: 'Оплата',
            },

            {
                identif: 'confirmation',
                icon: 'symbol-confirmation',
                stepName: 'Шаг четвёртый',
                title: 'Подтверждение',
            },
        ],

        active: 0,
        direction: 'forward'
    },

    actions: {
        set({ commit }, stepName) {
            stepName = stepName.toLowerCase()

            for (let i = 0; i < state.steps.length; i++) {
                if (state.steps[i].identif.toLowerCase() === stepName) {
                    if (i === state.active) {
                        return
                    }

                    if (i > state.active) {
                        state.direction = 'forward'
                    }
                    else {
                        state.direction = 'back'
                    }

                    commit(actionTypes.CHECKOUT_SET_STEP, i)
                    return
                }
            }
        },

        next({ state, dispatch }) {
            dispatch('setByIndex', state.active + 1)
        },

        prev({ state, dispatch }) {
            dispatch('setByIndex', state.active - 1)
        },

        setByIndex({ state, commit }, index) {
            if (index in state.steps) {
                commit(actionTypes.CHECKOUT_SET_STEP, index)
            }
        }
    },

    mutations: {
        [actionTypes.CHECKOUT_SET_STEP](state, newActiveIndex) {

            if (newActiveIndex > state.active) {
                state.direction = 'forward'
            }
            else {
                state.direction = 'back'
            }

            state.active = newActiveIndex
        },
    },

    getters: {
        activeTab(state) {
            return state.steps[state.active].identif
        }
    }
}
