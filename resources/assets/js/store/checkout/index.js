import * as actionTypes from './types'
import Core from '../../scripts/core'
import SmoothScroll from '../../scripts/SmoothScroll'
import HistoryProxy from '../../scripts/HistoryProxy'
import Request from "../../scripts/Request"
import storageActionsExtension from '../storageActionsExtension'

let hp = new HistoryProxy()

function getStepIndex(state, identif) {
    identif = identif.toLowerCase()

    for (let i = 0; i < state.steps.length; i++) {
        if (state.steps[i].identif.toLowerCase() === identif) {
            return i
        }
    }

    return false
}

function setStepIndex(state, index) {
    hp.setHash(index === 0 ? '' : state.steps[index].identif)
}

function scrollToStart(cb) {
    SmoothScroll.scrollIfItNeeds(document.querySelector('.js-checkout'), null, cb)
}

export default {
    namespaced: true,

    state: {
        steps: [
            {
                identif: 'cart',
                icon: 'symbol-cart',
                stepName: 'Шаг первый',
                title: 'Корзина',
                goal: 'cart-step-1'
            },

            {
                identif: 'shipping',
                icon: 'symbol-truck',
                stepName: 'Шаг второй',
                title: 'Доставка',
                goal: 'cart-step-2'
            },

            // {
            //     identif: 'payment',
            //     icon: 'symbol-credit-card',
            //     stepName: 'Шаг третий',
            //     title: 'Оплата',
            //     goal: 'cart-step-3'
            // },

            {
                identif: 'confirmation',
                icon: 'symbol-confirmation',
                stepName: 'Шаг четвёртый',
                title: 'Подтверждение',
                goal: 'cart-step-4'
            },
        ],

        active: 0,
        direction: 'forward',

        loading: false,
        request: null,
        error: false,
        errorCounter: 0,

        goals: []
    },

    actions: {
        ... storageActionsExtension,

        init({ state, dispatch, commit }) {
            dispatch('initStorageExtension', 'checkout')
                .then(() => {
                    let index = getStepIndex(state, hp.getHash('hash'))

                    if (index !== false) {
                        state.active = index
                    }
                    else {
                        setStepIndex(state, state.active)
                    }

                    dispatch('reachGoal', 'cart-step-' + (state.active + 1))

                    if (! state.ready) {
                        let baseUrl = Core.siteUrl('cart')

                        window.addEventListener('popstate', function () {
                            if (window.location.href.indexOf(baseUrl) === 0) {
                                dispatch('setByIndex', [getStepIndex(state, hp.getHash('hash')) || 0, false])
                            }
                            else {
                                window.location.reload()
                            }
                        }, { passive: true })

                        commit(actionTypes.CHECKOUT_READY)
                    }
                })
        },

        set({ state, dispatch }, stepName) {
            dispatch('setByIndex', [getStepIndex(state, stepName)])
        },

        next({ state, dispatch }) {
            dispatch('setByIndex', [state.active + 1])
        },

        prev({ state, dispatch }) {
            dispatch('setByIndex', [state.active - 1])
        },

        reachGoal({state, dispatch, commit}, goal) {
            if (state.goals.indexOf(goal) !== -1) {
                return
            }

            Core.metrika.reachGoal(goal)

            commit(actionTypes.CHECKOUT_REACH_GOAL, [
                ... state.goals,
                goal,
            ])

            return dispatch('updateStorage', 'goals')
        },

        clear({dispatch}) {
            dispatch('clearStorageData')
        },

        setByIndex({ state, dispatch, commit }, [index, toHistory = true]) {
            if (state.loading) return

            if (state.active !== index && index in state.steps) {
                scrollToStart(() => {
                    commit(actionTypes.CHECKOUT_SET_STEP, index)
                    dispatch('updateStorage', 'active')
                    dispatch('reachGoal', 'cart-step-' + (index + 1))
                })

                if (toHistory) {
                    setStepIndex(state, index)
                }
            }
        },

        clearIndex({commit, dispatch}) {
            commit(actionTypes.CHECKOUT_SET_STEP, 0)

            dispatch('initStorageExtension', 'checkout')
                .then(() => dispatch('updateStorage', 'active'))
        },

        submit({state, rootState, commit, dispatch}) {
            if (state.loading) return

            commit(actionTypes.CHECKOUT_REQUEST_START)

            let data = {
                cart: {
                    products: rootState.cart.cart.items.reduce((acc, item) => {
                        acc[item.getKey()] = item.getQuantity()

                        return acc
                    }, {}),
                    promo_code: rootState.cart.promo.name
                },
                shipping: {
                    type: rootState.shipping.type,
                    data: {... rootState.shipping.data}
                },
                pay_type: rootState.payments.active
            }

            state.request =
                new Request('post', Core.siteUrl('checkout'), data)
                    .success(response => {
                        dispatch('shipping/clearStorageData', null, {root: true})
                            .then(() => dispatch('cart/clearStorageData', null, {root: true}))
                            .then(() => {
                                dispatch('reachGoal', 'cart-step-4')
                                    .then(() => dispatch('clear'))
                                    .then(() => {
                                        if ('data' in response && 'status' in response.data) {
                                            window.location.href = response.data._redirect
                                        }
                                    })
                            })
                    })
                    .fail(() => {
                        if (++ state.errorCounter > 2) {
                            window.location.reload()
                        }
                        else {
                            commit(actionTypes.CHECKOUT_REQUEST_FAIL)
                        }
                    })
                    .start()
        }
    },

    mutations: {
        [actionTypes.CHECKOUT_READY](state) {
            state.ready = true
        },

        [actionTypes.CHECKOUT_SET_STEP](state, newActiveIndex) {
            if (newActiveIndex > state.active) {
                state.direction = 'forward'
            }
            else {
                state.direction = 'back'
            }

            state.active = newActiveIndex
        },

        [actionTypes.CHECKOUT_REQUEST_START](state) {
            state.loading = true
            state.error = false
        },

        [actionTypes.CHECKOUT_REQUEST_SUCCESS](state) {
            state.loading = false
        },

        [actionTypes.CHECKOUT_REQUEST_FAIL](state) {
            state.loading = false
            state.error = true
        },

        [actionTypes.CHECKOUT_REACH_GOAL](state, goals) {
            state.goals = goals
        }
    },

    getters: {
        activeTab(state) {
            return state.steps[state.active].identif
        }
    }
}
