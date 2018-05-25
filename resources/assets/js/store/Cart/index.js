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
        this.key = key
        this.setQty(qty)
        this.loaded = false
    }

    getMaxQty() {
        if (this.loaded && _.isNumber(this.info.remnant)) {
            return this.info.remnant
        }

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

function handleSuccessResponse(response = {}, state = {}) {
    let data = response.data || {}
    state.items = itemsToCartItems(data.items)
    state.lastSyncTime = data.time
    state.ready = true
    state.synchronized = true
    state.loading = false

    return itemsToCartItems (response.data.items)
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
        if (item.key === key) {
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
        },

        updateItem({ commit, dispatch }, keyQtyArr) {
            commit(actionTypes.CART_UPDATE_ITEM, keyQtyArr)

            dispatch('dirty')
        },

        removeItem({ commit, dispatch }, key) {
            commit(actionTypes.CART_REMOVE_ITEM, key)

            dispatch('dirty')
        },

        clear({ commit, dispatch }) {
            commit(actionTypes.CART_CLEAR)

            dispatch('dirty')
        },

        dirty({ state, commit, dispatch }) {
            commit(actionTypes.CART_DIRTY)
            dispatch('updateLocalCart')

            this.dirtyDebouncer()

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

            this.dirtyDebouncer = _.debounce(() => dispatch('sync'), 400)

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

        load({ state, commit, dispatch }) {
            commit(actionTypes.CART_LOAD_REQUEST)

            this.cancelToken = new axios.CancelToken(c => this.abortRequest = c)

            axios.request({
                url: Core.siteUrl('cart'),
                method: 'post',
                cancelToken: this.cancelToken
            })
                .then(response => {
                    commit(actionTypes.CART_LOAD_SUCCESS, response)
                    dispatch('updateLocalCart')
                })
                .catch(thrown => {
                    if (! axios.isCancel(thrown)) {
                        commit(actionTypes.CART_LOAD_FAILURE)
                    }
                })
        },

        sync({ state, commit, dispatch }) {
            let syncData = {
                time: state.lastSyncTime,
                items: state.items.map(item => ({
                    key: item.key,
                    qty: item.qty
                }))
            }

            commit(actionTypes.CART_SYNC_REQUEST)

            this.cancelToken = new axios.CancelToken(c => this.abortRequest = c)

            axios.request({
                url: Core.siteUrl('cart'),
                method: 'put',
                data: syncData,
                cancelToken: this.cancelToken
            })
                .then(response => {
                    commit(actionTypes.CART_SYNC_SUCCESS, response)
                    dispatch('updateLocalCart')
                })
                .catch(thrown => {
                    if (! axios.isCancel(thrown)) {
                        commit(actionTypes.CART_SYNC_FAILURE)
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
            state.items = state.items.filter(item => item.key !== key)
        },

        [actionTypes.CART_CLEAR](state) {
            state.items = []
        },

        [actionTypes.CART_DIRTY](state) {
            state.synchronized = false
        },

        [actionTypes.CART_LOAD_REQUEST](state) {
            state.loading = true
            state.error = false
        },

        [actionTypes.CART_LOAD_SUCCESS](state, response) {
            handleSuccessResponse(response, state)
        },

        [actionTypes.CART_LOAD_FAILURE](state) {
            state.loading = false
            state.ready = false
            state.error = true
        },

        [actionTypes.CART_SYNC_REQUEST](state) {
            state.loading = true
            state.error = false
        },

        [actionTypes.CART_SYNC_SUCCESS](state, response) {
            handleSuccessResponse(response, state)
        },

        [actionTypes.CART_SYNC_FAILURE](state) {
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
    }
}


