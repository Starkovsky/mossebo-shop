import * as actionTypes from './types'
import storageActionsExtension from '../../../../../storageActionsExtension'
import Core from "../../../../../../scripts/core/index"

export default {
    namespaced: true,

    state: {
        types: {
            useful: Core.translate('Usefulness'),
            new: Core.translate('Date'),
        },

        active: 'useful',
    },

    actions: {
        ... storageActionsExtension,

        init({dispatch}) {
            return dispatch('initStorageExtension', 'reviews::sort')
        },

        setType({state, dispatch, commit}, type) {
            if (type in state.types && type !== state.active) {
                commit(actionTypes.REVIEWS_SORT_SET_TYPE, type)
                return dispatch('updateStorage', 'active')
            }
        }
    },

    mutations: {
        [actionTypes.REVIEWS_SORT_SET_TYPE](state, type) {
            state.active = type
        }
    }
}
