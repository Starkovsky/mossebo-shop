import * as actionTypes from './types'
import Core from '../../scripts/core'
import DataHandler from '../../scripts/DataHandler'
import storageActionsExtension from '../storageActionsExtension'
import Request from '../../scripts/Request'

import PromoModule from './modules/promo'

export function makeKey (id, options = []) {
    return options.sort((a, b) => a - b).reduce((acc, optionId) => {
        return acc + '-' + optionId
    }, id)
}

class CartItem {
    constructor(key, qty = 0) {
        this.key = key.toString()
        this.setQty(qty)
        this.loaded = false
    }

    hasKey(key) {
        if (! key) return false
        return this.key === key.toString()
    }

    getMaxQty() {
        // if (this.loaded && _.isNumber(this.info.remnant)) {
        //     return this.info.remnant
        // }

        return 99
    }

    getMinQty() {
        return 1
    }

    setQty(qty) {
        this.qty = Math.min(this.getMaxQty(), Math.max(this.getMinQty(), qty))
    }

    add(qty) {
        this.setQty(this.qty + qty)

        return this
    }

    update(qty) {
        this.setQty(qty)

        return this
    }

    isLoaded() {
        return this.loaded
    }

    getInfo() {
        return this.info
    }

    setProductInfo(info) {
        this.info = {
            ... info
        }

        this.setQty(this.qty)

        this.loaded = true

        return this
    }
}

function itemsToCartItems(items = []) {
    return items.map(item => {
        if (item instanceof CartItem) return item

        let ci = new CartItem(item.key, item.qty)

        if (item.info){
            ci.setProductInfo(item.info)
        }

        return ci
    })
}

function operateItem(items, method, key, qty) {
    let changed = false

    let result = items.map(item => {
        if (item.hasKey(key)) {
            item[method](qty)
            changed = true
        }

        return item
    })

    if (!changed) {
        result.push(new CartItem(key, qty))
    }

    return result
}

export default {
    namespaced: true,

    modules: {
        promo: PromoModule
    },

    state: {
        time: null, // время последней синхронизации
        ready: false,
        loading: false,
        error: false,
        synchronized: false,
        items: [],
        options: [],
        abortRequest: null,
        request: null
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
            if (!state.time) {
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
            dispatch('add', keyQtyArr)
        },

        updateItem({ commit, dispatch }, keyQtyArr) {
            commit(actionTypes.CART_UPDATE_ITEM, keyQtyArr)

            dispatch('dirty')
            this.syncDebouncer()
        },

        removeItem({ commit, dispatch }, key) {
            commit(actionTypes.CART_REMOVE_ITEM, key)

            dispatch('dirty')
            this.syncDebouncer()
        },

        clear({ commit, dispatch }) {
            commit(actionTypes.CART_CLEAR)

            dispatch('dirty')
            this.syncDebouncer()
        },

        dirty({ state, commit, dispatch }) {
            commit(actionTypes.CART_DIRTY)

            dispatch('updateStorage', ['items', 'synchronized'])

            if (state.loading && _.isFunction(state.abortRequest)) {
                state.abortRequest()
            }
        },

        loadOptionsDescription({ commit }) {
            return DataHandler.get('attributes')
                .then(data => commit(actionTypes.CART_SET_OPTION_DESCRIPTIONS, data.attributes))
                .catch(() => {
                    DataHandler.flush()
                })
        },

        add({dispatch}, item) {
            dispatch('request', {
                method: 'put',
                url: Core.siteUrl('cart/' + item[0]),
                data: {
                    qty: item[1] || 1,
                }
            })
        },

        request({ state, commit, dispatch }, config) {
            if (state.request) {
                state.request.abort()
            }

            commit(actionTypes.CART_REQUEST_START)

            state.request = new Request(config.method, config.url, config.data || null)
                .success(response => {
                    let data = response.data

                    commit(actionTypes.CART_REQUEST_SUCCESS, data)

                    let queue

                    if ('promoCode' in data.cart) {
                        queue = dispatch('applyPromoCode', data.cart.promoCode)
                    }
                    else {
                        queue = dispatch('clearPromoCode')
                    }

                    queue.then(() => dispatch('updateStorage', ['items', 'time', 'synchronized']))
                })
                .any(() => state.request = null)
                .silent()
                .start()
        },

        load({ state, commit, dispatch }) {
            return dispatch('request', {
                url: Core.siteUrl('cart'),
                method: 'post',
            })
        },

        sync({ state, dispatch }) {
            return dispatch('request', {
                url: Core.siteUrl('cart'),
                method: 'put',
                data: {
                    time: state.time,
                    items: state.items.map(item => ({
                        key: item.key,
                        qty: item.qty
                    }))
                },
            })
        },

        applyPromoCode({ state, dispatch }, promoCode) {
            return dispatch('promo/apply', promoCode)
        },

        errorPromoCode({ state, dispatch }, promoCode) {
            return dispatch('promo/error', promoCode)
        },

        clearPromoCode({ state, dispatch }) {
            return dispatch('promo/clear')
        },

        _sSetCartItems: {
            root: true,
            handler({state}, items) {
                state.items = itemsToCartItems(items)
            }
        },

        _sPrepareCartItems: {
            root: true,
            handler({state}) {
                return state.items.map(item => ({
                    key: item.key,
                    qty: item.qty
                }))
            }
        }
    },

    mutations: {
        [actionTypes.CART_ADD_ITEM](state, [key, qty = 1]) {
            state.items = operateItem(state.items, 'add', key, qty)
        },

        [actionTypes.CART_UPDATE_ITEM](state, [key, qty]) {
            state.items = operateItem(state.items, 'update', key, qty)
        },

        [actionTypes.CART_REMOVE_ITEM](state, key) {
            state.items = state.items.filter(item => !item.hasKey(key))
        },

        [actionTypes.CART_CLEAR](state) {
            state.items = []
        },

        [actionTypes.CART_DIRTY](state) {
            state.synchronized = false
        },

        [actionTypes.CART_REQUEST_START](state) {
            state.loading = true
            state.error = false
        },

        [actionTypes.CART_READY](state) {
            state.ready = true
        },

        [actionTypes.CART_REQUEST_SUCCESS](state, data = {}) {
            state.items = itemsToCartItems(data.cart.products)
            state.time = data.time
            state.ready = true
            state.synchronized = true
            state.loading = false
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
        loaded(state) {
            return state.items.filter(item => item.isLoaded())
        },

        products(state, getters) {
            return getters.loaded.map(item => {
                let product = {
                    ... item.getInfo(),
                    quantity: item.qty,
                    key: item.key
                }

                if (! (_.isEmpty(state.options) || _.isEmpty(product.options))) {
                    product.attributes = product.options.reduce((acc, id) => {
                        if (id in state.options) {
                            acc.push(state.options[id])
                        }

                        return acc
                    }, []).join(', ')
                }

                return product
            })
        },

        promoDiscount(state, getters) {
            let discountValue = 0

            if (getters['promo/type'] === 'amount') {
                discountValue = getters.amount * state.promo.percent / 100

                discountValue = Math.min(state.promo.amount, discountValue)
            }

            if (getters['promo/type'] === 'percent') {
                discountValue = getters.amount * state.promo.percent / 100
            }

            return discountValue
        },

        amount(state, getters) {
            return getters.products.reduce((acc, product) => {
                acc += product.quantity * product.price

                return acc
            }, 0)
        },

        total(state, getters) {
            return getters.amount - getters.promoDiscount
        },

        quantity(state) {
            return state.items.reduce((acc, item) => acc + item.qty, 0)
        },

        isEmpty(state, getters) {
            return getters.loaded.length === 0
        },

        stepNotDone(state, getters) {
            return state.loading || state.error || getters.isEmpty || !(state.ready && state.synchronized)
        }
    }
}


