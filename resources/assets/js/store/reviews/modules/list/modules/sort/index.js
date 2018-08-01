import * as actionTypes from './types'
import localStorageActionsExtension from '../../../../../localStorageActionsExtension'
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
        ... localStorageActionsExtension,

        init({dispatch}) {
            return dispatch('initLocalStorageExtension', 'reviews::sort')
        },

        setType({state, dispatch, commit}, type) {
            if (type in state.types && type !== state.active) {
                commit(actionTypes.REVIEWS_SORT_SET_TYPE, type)
                return dispatch('updateLocalStorage', 'active')
            }
        }
    },

    mutations: {
        [actionTypes.REVIEWS_SORT_SET_TYPE](state, type) {
            state.active = type
        }
    }
}
