<template>
    <div :class="{'search-input': true, 'is-opened': isOpened}">
        <form @submit="submit">
            <input
                type="text"
                class="search-input__input form-input"
                :placeholder="placeholder$"
                :value="query"
                @input="input"
            >

            <button class="search-input__button">
                <svg class="search-input__icon symbol-icon symbol-search">
                    <use xlink:href="/assets/images/icons.svg#symbol-search"></use>
                </svg>
            </button>
        </form>

        <div class="search-input__loading" v-if="loading">
            <loading-icon class="search-input__loading-icon"></loading-icon>
        </div>

        <div class="search-input__result">
            <div class="search-result">
                <a
                    class="search-result__link"
                    v-for="item in result"
                    :href="getUrl(item)"
                    :key="item.id"
                >
                    {{ item.name }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    import Core from '../scripts/core'
    import RequestMixin from '../mixins/RequestMixin'
    import LoadingIcon from './LoadingIcon'

    export default {
        name: 'SearchInput',

        mixins: [
            RequestMixin
        ],

        props: [
            'placeholder'
        ],

        data() {
            return {
                query: '',
                result: [],
                inFocus: false,
                placeholder$: this.placeholder || this.$root.translate('Search')
            }
        },

        watch: {
            stateQuery: 'updateQueryFromState'
        },

        components: {
            LoadingIcon
        },

        mounted() {
            let input = this.$el.querySelector('input')

            this.clickHandler = e => {
                if (input.contains(e.target)) {
                    if (! this.inFocus) {
                        this.inFocus = true
                    }
                }
                else {
                    if (this.inFocus) {
                        this.inFocus = false
                    }
                }
            }

            window.addEventListener('click', this.clickHandler, {passive: true})
            this.updateQueryFromState()
        },

        beforeDestroy() {
            window.removeEventListener('click', this.clickHandler)
        },

        methods: {
            fetchQueryResult() {
                this.abortRequest()
                if (this.query === '') return

                this.sendRequest('get', Core.apiUrl('search/query'), {
                    q: this.query
                })
                    .silent()
                    .success(response => {
                        this.result = response.data.products || []
                    })
            },

            input(e) {
                if (this.isSearchPage()) {
                    this.$store.dispatch('catalog/setSearchQuery', e.target.value)
                }
                else {
                    this.query = e.target.value
                    this.fetchQueryResult()
                }
            },

            updateQueryFromState() {
                this.query = this.stateQuery
            },

            submit(e) {
                e.preventDefault()

                if (this.isSearchPage()) {
                    this.$store.dispatch('catalog/forceSearch')
                }
                else {
                    if (this.query !== '') {
                        let url = Core.siteUrl('search')
                        window.location.href = Core.updateQueryStringParameter(url, 'q', this.query)
                    }
                }
            },

            getUrl(item) {
                return Core.siteUrl('goods/' + item.id)
            },

            isSearchPage() {
                return window.location.href.indexOf(Core.siteUrl('search')) === 0
            }
        },

        computed: {
            isOpened() {
                return this.inFocus && this.result.length > 0
            },

            ... mapState({
                stateQuery: state => state.catalog.search.query
            })
        }
    }
</script>
