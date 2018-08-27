import * as actionTypes from './types'
import ListModule from './modules/list'
import FormModule from './modules/form'
import Request from '../../scripts/Request'
import Core from "../../scripts/core"

export default {
    modules: {
        list: ListModule,
        form: FormModule,
    },

    namespaced: true,

    state: {
        steps: [
            'list',
            'form'
        ],

        formReview: null,

        active: 'list',
        direction: 'forward',
        ready: false
    },

    actions: {
        init({ state, dispatch, commit }) {
            if (state.ready) return

            return Promise.all([dispatch('list/init'), dispatch('form/init')])
                .then(() => commit(actionTypes.REVIEWS_READY))
        },

        destroy({dispatch}) {
            return Promise.all([dispatch('list/destroy'), dispatch('form/destroy')])
        },

        set({ state, commit }, stepName) {
            if (state.steps.indexOf(stepName) === -1) return

            commit(actionTypes.REVIEWS_SET_STEP, stepName)
        },

        toForm({ state, dispatch }) {
            dispatch('set', 'form')
        },

        toList({ state, dispatch }) {
            dispatch('set', 'list')
        },

        setFormValue({dispatch}, value) {
            dispatch('form/setValue', value)
        },

        editReview({ state, dispatch, commit }, review) {
            commit(actionTypes.REVIEWS_SET_FORM_REVIEW, review)

            dispatch('form/editReview', review)
                .then(() => dispatch('toForm'))
        },

        removeReview({ state, dispatch }, review) {
            dispatch('list/loading')
                .then(() => {
                    (new Request('delete', Core.siteUrl('reviews/' + review.id)))
                        .success(() => dispatch('list/reFetch'))
                        .silent()
                        .start()
                })
        },

        cancelForm({dispatch, commit}) {
            commit(actionTypes.REVIEWS_SET_FORM_REVIEW, null)

            dispatch('toList')
                .then(() => dispatch('form/clear'))
        },

        sendForm({state, dispatch}) {
            let url, method

            if (state.formReview) {
                url = Core.siteUrl('reviews/' + state.formReview.id)
                method = 'post'
            }
            else {
                url = window.location.origin + window.location.pathname + '/reviews'
                method = 'put'
            }

            dispatch('form/save', [method, url])
                .then(request => {
                    request
                        .success(() => {
                            dispatch('list/reFetch')
                            dispatch('cancelForm')
                        })
                })
        }
    },

    mutations: {
        [actionTypes.REVIEWS_READY](state) {
            state.ready = true
        },

        [actionTypes.REVIEWS_SET_STEP](state, step) {
            let currentIndex = state.steps.indexOf(state.active)
            let newIndex = state.steps.indexOf(step)

            if (newIndex > currentIndex) {
                state.direction = 'forward'
            }
            else {
                state.direction = 'back'
            }

            state.active = step
        },

        [actionTypes.REVIEWS_SET_FORM_REVIEW](state, review) {
            state.formReview = review
        }
    },

    getters: {
        activeTab(state) {
            return state.steps[state.active]
        }
    }
}
