import * as actionTypes from './types'
import Core from '../../scripts/core'
import DataHandler from '../../scripts/DataHandler'
import storageActionsExtension from '../storageActionsExtension'
import Request from '../../scripts/Request'

import PromoModule from './modules/promo'
import Cart, { makeKey } from '../../scripts/shop/Cart'
import PromoCode from '../../scripts/shop/PromoCode'


export default {
    namespaced: true,

    modules: {
        promo: PromoModule
    },

    state: {
        cart: new Cart(),
        time: null, // время последней синхронизации
        ready: false,
        loading: false,
        error: false,
        synchronized: false,
        options: [],
        abortRequest: null,
        request: null,
        requestTime: null
    },

    actions: {
        ... storageActionsExtension,

        refresh({ state, dispatch }) {
            if (state.ready) {
                return dispatch('getCartRequestType')
                    .then(type => dispatch(type))
            }

            return dispatch('init')
        },

        init({ commit, state, dispatch }) {
            if (state.ready || state.loading) {
                return
            }

            state.loading = true

            this.syncDebouncer = _.debounce(() => dispatch('sync'), 400)

            dispatch('initStorageExtension', 'cart')
                .then(() => dispatch('getCartRequestType'))
                .then(type => Promise.all([dispatch(type), dispatch('loadOptionsDescription')]))
        },

        getCartRequestType({state}) {
            if (! state.time) {
                return 'load'
            }
            else {
                if (state.synchronized) {
                    return 'load'
                }
                else {
                    return 'sync'
                }
            }
        },

        addProduct({ commit, dispatch }, [{id, options}, qty]) {
            dispatch('addItem', [makeKey(id, options), qty])
        },

        updateProduct({ commit, dispatch }, [{id, options}, qty]) {
            dispatch('updateItem', [makeKey(id, options), qty])
        },

        removeProduct({ commit, dispatch }, {id, options}) {
            dispatch('removeItem', makeKey(id, options))
        },

        addItem({ commit, dispatch }, keyQtyArr) {
            commit(actionTypes.CART_ADD_ITEM, keyQtyArr)

            dispatch('dirty')
                .then(() => {
                    dispatch('add', keyQtyArr)
                })
        },

        updateItem({ commit, dispatch }, keyQtyArr) {
            commit(actionTypes.CART_UPDATE_ITEM, keyQtyArr)

            dispatch('dirty')
                .then(() => {
                    this.syncDebouncer()
                })
        },

        removeItem({ commit, dispatch }, key) {
            commit(actionTypes.CART_REMOVE_ITEM, key)

            dispatch('dirty')
                .then(() => {
                    this.syncDebouncer()
                })
        },

        clear({ commit, dispatch }) {
            commit(actionTypes.CART_CLEAR)

            dispatch('dirty')
                .then(() => {
                    this.syncDebouncer()
                })
        },

        dirty({ state, commit, dispatch }) {
            commit(actionTypes.CART_DIRTY)

            if (state.loading && _.isFunction(state.abortRequest)) {
                state.abortRequest()
            }

            return Promise.all([
                dispatch('updateStorage', ['items', 'synchronized']),
                dispatch('checkout/clearIndex', null, {root: true}),
            ])
        },

        loadOptionsDescription({ commit }) {
            return DataHandler.get('attributes')
                .then(data => commit(actionTypes.CART_SET_OPTION_DESCRIPTIONS, data.attributes))
                .catch(() => {
                    DataHandler.flush()
                })
        },

        add({dispatch}, item) {
            return dispatch('request', {
                method: 'put',
                url: Core.siteUrl('cart/' + item[0]),
                data: {
                    qty: item[1] || 1,
                }
            })
        },

        abortableRequest({ state, dispatch }, config) {
            if (state.request) {
                state.request.abort()
            }

            return dispatch('request', config)
                .then(request => {
                    state.request = request.any(() => state.request = null)
                })
        },

        request({ state, commit, dispatch }, config) {
            let startTime = performance.now()

            commit(actionTypes.CART_REQUEST_START, startTime)

            return new Request(config.method, config.url, config.data || null)
                .success(response => {
                    if (state.requestTime === startTime) {
                        dispatch('setCart', response.data)
                    }
                })
                .silent()
                .start()
        },

        load({ state, commit, dispatch }) {
            return dispatch('abortableRequest', {
                url: Core.siteUrl('cart'),
                method: 'post',
            })
        },

        sync({ state, dispatch }) {
            return dispatch('abortableRequest', {
                url: Core.siteUrl('cart'),
                method: 'put',
                data: {
                    time: state.time,
                    items: state.cart.getItems().map(item => ({
                        key: item.getKey(),
                        qty: item.getQuantity()
                    }))
                },
            })
        },

        setCart({commit, dispatch}, data = {}) {
            commit(actionTypes.CART_REQUEST_SUCCESS, data)

            let queue

            if ('promoCode' in data.cart) {
                queue = dispatch('setPromoCode', data.cart.promoCode)
            }
            else {
                queue = dispatch('clearPromoCode')
            }

            queue.then(() => dispatch('updateStorage', ['items', 'time', 'synchronized']))

            return queue
        },

        setPromoCode({ state, dispatch }, promoCodeData) {
            state.cart.setPromo(
                new PromoCode(promoCodeData)
            )

            return dispatch('promo/set', promoCodeData)
        },

        clearPromoCode({ state, dispatch }) {
            state.cart.removePromo()

            return dispatch('promo/clear')
        },

        _sSetCartItems: {
            root: true,
            handler({state}, items) {
                state.cart.setProducts(items)
            }
        },

        _sPrepareCartItems: {
            root: true,
            handler({state}) {
                return state.cart.getProducts().map(item => ({
                    key: item.getKey,
                    qty: item.getQuantity()
                }))
            }
        }
    },

    mutations: {
        [actionTypes.CART_ADD_ITEM](state, [key, quantity = 1]) {
            state.cart.add(key, quantity)
        },

        [actionTypes.CART_UPDATE_ITEM](state, [key, quantity]) {
            state.cart.set(key, quantity)
        },

        [actionTypes.CART_REMOVE_ITEM](state, key) {
            state.cart.remove(key)
        },

        [actionTypes.CART_CLEAR](state) {
            state.cart.clear()
        },

        [actionTypes.CART_DIRTY](state) {
            state.synchronized = false
        },

        [actionTypes.CART_REQUEST_START](state, time) {
            state.loading = true
            state.error = false
            state.requestTime = time
        },

        [actionTypes.CART_READY](state) {
            state.ready = true
        },

        [actionTypes.CART_REQUEST_SUCCESS](state, data = {}) {
            state.time = data.time
            state.ready = true
            state.synchronized = true
            state.loading = false

            let items = data.cart.products

            if (! (_.isEmpty(state.options))) {
                items.forEach(item => {
                    if (_.isEmpty(item.data.options)) return

                    item.data.attributes = item.data.options.reduce((acc, id) => {
                        if (id in state.options) {
                            acc.push(state.options[id])
                        }

                        return acc
                    }, []).join(', ')
                })
            }

            state.cart.setProducts(items)
        },

        [actionTypes.CART_REQUEST_FAILURE](state) {
            state.loading = false
            state.error = true
        },

        [actionTypes.CART_SET_OPTION_DESCRIPTIONS](state, attributes) {
            state.options = attributes.reduce((acc, attribute) => {
                (attribute.options || []).forEach(option => {
                    acc[option.id] = option.title
                })

                return acc
            }, {})
        }
    },

    getters: {
        products(state) {
            return state.cart.getProducts()
        },

        promoDiscount(state) {
            return state.cart.getPromoDiscount()
        },

        amount(state) {
            return state.cart.getAmount()
        },

        total(state) {
            return state.cart.getTotal()
        },

        quantity(state) {
            return state.cart.getProductsQuantity()
        },

        isEmpty(state, getters) {
            return getters.products.length === 0
        },

        stepNotDone(state, getters) {
            return state.loading || state.error || getters.isEmpty || !(state.ready && state.synchronized)
        }
    }
}
