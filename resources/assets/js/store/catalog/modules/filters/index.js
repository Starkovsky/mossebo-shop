import * as actionTypes from './types'
import makeFilters from "./filterMaker"
import DataHandler from "../../../../scripts/DataHandler"
import BaseOptionsFilter from "../../modules/filters/items/BaseOptionsFilter"

export default {
    namespaced: true,

    state: {
        types: ['attributes', 'styles', 'rooms', 'categories'],
        filtering: false,
        filters: [],
        isDirty: false,
        lastFilterId: null,
    },

    actions: {
        fetchFilters({state}) {
            return DataHandler.get(state.types)
        },

        makeFilters({state}, products) {
            return makeFilters(products, state.types)
        },

        calculateProductCountPerOption({state}, products) {
            state.filters.forEach(filter => {
                if (filter instanceof BaseOptionsFilter) {
                    products.forEach(product => {
                        filter.addProductToCount(product)
                    })

                    filter.applyProductCount()
                }
            })
        },

        setTypes({commit}, types) {
            commit(actionTypes.CATALOG_SET_TYPES, types)
        },

        setFilters({commit}, filtes) {
            commit(actionTypes.CATALOG_SET_FILTERS, filtes)
        },

        filter({state, dispatch}, products) {
            if (state.filters.length === 0) {
                return [
                    ... products.keys()
                ]
            }
            else {
                return products.reduce((acc, product, index) => {
                    let group = false
                    let flag = true

                    for (let i = 0; i < state.filters.length; i++) {
                        if (! state.filters[i].checkProduct(product)) {
                            if (flag) {
                                flag = false
                                group = state.filters[i]
                            }
                            else {
                                group = false
                                break
                            }
                        }
                    }

                    if (group) {
                        group.prepareActiveOptions(product)
                    }

                    if (flag) {
                        acc.push(index)
                    }

                    return acc
                }, [])
            }
        },

        setValue({state, commit}, [filterId, value]) {
            let isDirty = false

            state.filters.forEach(filter => {
                if (filter.id === filterId) {
                    filter.setValue(value)
                }

                if (! isDirty) {
                    isDirty = filter.isDirty()
                }
            })

            commit(actionTypes.CATALOG_FILTERS_DIRTY, isDirty)
        },

        applyActiveOptions({state}, products) {
            state.filters.forEach(filter => {
                products.forEach(product => {
                    filter.prepareActiveOptions(product)
                })

                filter.applyActiveOptions(state.lastFilterId)
            })
        },

        clear({state, commit}) {
            if (! state.isDirty) return

            state.filters.forEach(filter => {
                filter.clear()
            })

            commit(actionTypes.CATALOG_FILTERS_DIRTY, false)
        }
    },

    mutations: {
        [actionTypes.CATALOG_SET_FILTERS](state, filters) {
            state.filters = filters
        },

        [actionTypes.CATALOG_SET_TYPES](state, types) {
            state.types = types
        },

        [actionTypes.CATALOG_FILTERING_START](state) {
            state.filters = filters
        },

        [actionTypes.CATALOG_FILTERING_FINISH](state) {
            state.filters = filters
        },

        [actionTypes.CATALOG_FILTERS_DIRTY](state, dirtyStatus) {
            state.isDirty = dirtyStatus
        }
    }
}
