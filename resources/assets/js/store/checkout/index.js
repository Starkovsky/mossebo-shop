import * as actionTypes from './types'
import Core from '../../scripts/core'
import SmoothScroll from '../../scripts/SmoothScroll'
import HistoryProxy from '../../scripts/HistoryProxy'
import Request from "../../scripts/Request"

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
        direction: 'forward',

        loading: false,
        request: null,
        error: false,
        errorCounter: 0
    },

    actions: {
        init({ state, dispatch, commit }) {
            dispatch('setByIndex', [getStepIndex(state, hp.getHash('hash')) || 0, false])

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

        setByIndex({ state, commit }, [index, toHistory = true]) {
            if (state.loading) return

            if (state.active !== index && index in state.steps) {
                scrollToStart(() => {
                    commit(actionTypes.CHECKOUT_SET_STEP, index)
                })

                if (toHistory) {
                    hp.setHash(index === 0 ? '' : state.steps[index].identif)
                }
            }
        },

        submit({state, rootState, commit, dispatch}) {
            if (state.loading) return

            commit(actionTypes.CHECKOUT_REQUEST_START)

            let data = {
                cart: {
                    products: rootState.cart.items.reduce((acc, item) => {
                        acc[item.key] = item.qty
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
                        dispatch('shipping/clearStorageData', null, {root:true})
                            .then(() => dispatch('cart/clearStorageData', null, {root:true}))
                            .then(() => {
                                window.location.href = Core.siteUrl('checkout/thanks/' + response.data.orderId)

                                commit(actionTypes.CHECKOUT_REQUEST_SUCCESS)
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
        }
    },

    getters: {
        activeTab(state) {
            return state.steps[state.active].identif
        }
    }
}
