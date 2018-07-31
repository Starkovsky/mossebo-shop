import * as actionTypes from "./types"
import Core from "../../../../scripts/core"
import Request from '../../../../scripts/Request'

function cleanString(string) {
    return string.toLowerCase().replace(/[^a-zа-я0-9]/gi, ' ').replace(/\s\s+/g, ' ')
}

export default {
    namespaced: true,

    state: {
        query: '',
        request: null,
    },

    actions: {
        init({state}) {
            let query = Core.getParameterByName('q')

            if (query) {
                state.query = query
            }
        },

        setQuery({state, commit}, query) {
            commit(actionTypes.CATALOG_SEARCH_SET_QUERY, query)

            Core.history.replace(Core.updateQueryStringParameter(window.location.href, 'q', state.query))
        },
    },

    mutations: {
        [actionTypes.CATALOG_SEARCH_SET_QUERY](state, query) {
            state.query = query
        }
    }
}


