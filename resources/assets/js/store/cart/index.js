import axios from 'axios'
import * as actionTypes from './types'
import LocalCart from './LocalCart'
import Core from '../../scripts/core'

function makeKey (id, options = []) {
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

    state: {
        lastSyncTime: null,
        ready: false,
        loading: false,
        error: false,
        synchronized: false,
        items: [],
    },

    actions: {
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

        dirty({ state, commit, dispatch }, sync = true) {
            commit(actionTypes.CART_DIRTY)
            dispatch('updateLocalCart')

            if (state.loading) {
                this.abortRequest()
            }
        },

        refresh({ dispatch }) {
            dispatch('sync')
        },

        init({ commit, state, dispatch }) {
            if (state.ready || state.loading) {
                return
            }

            this.syncDebouncer = _.debounce(() => dispatch('sync'), 400)

            if (!LocalCart.exists()) {
                dispatch('load')
            }
            else {
                let localCartData = LocalCart.get()

                if (localCartData.synchronized) {
                    dispatch('load')
                }
                else {
                    state.lastSyncTime = localCartData.time
                    state.items = itemsToCartItems(localCartData.items)
                    dispatch('sync')
                }
            }
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

        load({ dispatch }) {
            dispatch('request', {
                url: Core.siteUrl('cart'),
                method: 'post',
            })
        },

        sync({ state, dispatch }) {
            dispatch('request', {
                url: Core.siteUrl('cart'),
                method: 'put',
                data: {
                    time: state.lastSyncTime,
                    items: state.items.map(item => ({
                        key: item.key,
                        qty: item.qty
                    }))
                },
            })
        },

        request({ commit, dispatch }, config) {
            commit(actionTypes.CART_REQUEST_START)

            axios.request({
                ... config,
                cancelToken: new axios.CancelToken(c => this.abortRequest = c)
            })
                .then(response => {
                    commit(actionTypes.CART_REQUEST_SUCCESS, response)
                    dispatch('updateLocalCart')
                })
                .catch(thrown => {
                    if (! axios.isCancel(thrown)) {
                        commit(actionTypes.CART_REQUEST_FAILURE)
                    }
                })
        },

        updateLocalCart({ state }) {
            LocalCart.set({
                time: state.lastSyncTime,
                synchronized: state.synchronized,
                items: state.items.map(item => ({
                    key: item.key,
                    qty: item.qty
                })),
            })
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

        [actionTypes.CART_REQUEST_SUCCESS](state, response = {}) {
            let data = response.data || {}
            state.items = itemsToCartItems(data.items)
            state.lastSyncTime = data.time
            state.ready = true
            state.synchronized = true
            state.loading = false
        },

        [actionTypes.CART_REQUEST_FAILURE](state) {
            state.loading = false
            state.ready = false
            state.error = true
        },
    },

    getters: {
        loaded(state) {
            return state.items.filter(item => item.isLoaded())
        },

        products(state, getters) {
            return getters.loaded.map(item => ({
                ... item.getInfo(),
                quantity: item.qty
            }))
        },

        quantity(state) {
            return state.items.reduce((acc, item) => acc + item.qty, 0)
        },

        isEmpty(state) {
            return state.items.length === 0
        },

        stepNotDone(state, getters) {
            return state.loading || state.error || getters.isEmpty || !(state.ready && state.synchronized)
        }
    }
}


