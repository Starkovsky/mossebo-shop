import * as actionTypes from './types'
import Request from '../../../../scripts/Request'

function eacher(state) {
    return (cb) => {
        ['rate', 'advantages', 'disadvantages', 'comment', 'usage_time'].forEach(key => {
            cb(key, state[key])
        })
    }
}

export default {
    namespaced: true,

    state: {
        ready: false,

        title: '',
        rate: '',
        advantages: '',
        disadvantages: '',
        comment: '',
        usage_time: '',

        loading: false,
    },

    actions: {
        init({state, commit}) {
            if (state.ready || state.loading) return
            state.eacher = eacher(state)

            commit(actionTypes.REVIEW_FORM_READY)
        },

        destroy() {},

        setValue({state, commit}, [name, value]) {
            if (name in state) {
                commit(actionTypes.REVIEW_FORM_SET_VALUE, [name, value])
            }
        },

        editReview({state, commit}, review) {
            commit(actionTypes.REVIEW_FORM_EDIT_REVIEW, review)
        },

        clear({commit}) {
            commit(actionTypes.REVIEW_FORM_CLEAR)
        },

        save({state, commit}, [method, url]) {
            commit(actionTypes.REVIEW_FORM_REQUEST_START)

            let data = {}

            state.eacher((key, value) => {
                data[key] = value
            })

            return (new Request(method, url, data)).start()
                .success(() => commit(actionTypes.REVIEW_FORM_REQUEST_SUCCESS))
                .fail(() => commit(actionTypes.REVIEW_FORM_REQUEST_FAIL))
        },

    },

    mutations: {
        [actionTypes.REVIEW_FORM_SET_VALUE](state, [name, value]) {
            state[name] = value
        },

        [actionTypes.REVIEW_FORM_CLEAR](state) {
            state.eacher(key => state[key] = '')
        },

        [actionTypes.REVIEW_FORM_EDIT_REVIEW](state, review) {
            state.eacher(key => state[key] = review[key] || '')

            if (review.item && review.item.title) {
                state.title = review.item.title
            }
            else {
                state.title = ''
            }
        },

        [actionTypes.REVIEW_FORM_REQUEST_START](state) {
            state.loading = true
            state.error = false
        },

        [actionTypes.REVIEW_FORM_REQUEST_SUCCESS](state) {
            state.loading = false
            state.error = false
        },

        [actionTypes.REVIEW_FORM_REQUEST_FAIL](state) {
            state.loading = false
            state.error = true
        },

        [actionTypes.REVIEW_FORM_READY](state) {
            state.ready = true
        }
    }
}
