import * as actionTypes from "./types"
import PendingLoader, {makeLoader} from '../../../../scripts/PendingLoader'
import Core from "../../../../scripts/core"
import axios from 'axios'

function cleanString(string) {
    return string.toLowerCase().replace(/[^a-zа-я0-9]/gi, ' ').replace(/\s\s+/g, ' ')
}

export default {
    namespaced: true,

    state: {
        query: '',
        workingQuery: ''
    },

    actions: {
        init({state}) {
            let query = Core.getParameterByName('q')

            if (query) {
                state.query = query
                state.workingQuery = cleanString(query)
            }
        },

        setQuery({state, commit}, query) {
            commit(actionTypes.CATALOG_SEARCH_SET_QUERY, query)

            Core.history.replace(Core.updateQueryStringParameter(window.location.href, 'q', state.query))
        },

        search({state}) {
            return new Promise(resolve => {
                axios.get(Core.apiUrl('search'), {
                    params: {
                        query: state.query
                    }
                })
                    .then(response => {
                        console.log(response.data)
                        resolve(response.data.products)
                    })
                    .catch(thrown => {
                        console.log(thrown)
                    })
            })
        }
    },

    mutations: {
        [actionTypes.CATALOG_SEARCH_SET_QUERY](state, query) {
            state.query = query
            state.workingQuery = cleanString(query)
        }
    }
}


