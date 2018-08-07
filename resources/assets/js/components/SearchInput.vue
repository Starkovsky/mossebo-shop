<template>
    <div :class="{'search-input': true, 'is-opened': isOpened}">
        <form @submit="submit">
            <input
                type="text"
                class="search-input__input form-input"
                :placeholder="$root.translate('Search')"
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
            <svg
                class="search-input__loading-icon"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 100 100"
                enable-background="new 0 0 0 0"
                xml:space="preserve"
            >
                <circle stroke="none" cx="12%" cy="50%" r="12%">
                    <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.1"/>
                </circle>

                <circle stroke="none" cx="50%" cy="50%" r="12%">
                    <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.2"/>
                </circle>

                <circle stroke="none" cx="88%" cy="50%" r="12%">
                    <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.3"/>
                </circle>
            </svg>
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
    import Loading from './Loading'

    export default {
        name: 'SearchInput',

        mixins: [
            RequestMixin
        ],

        data() {
            return {
                query: '',
                result: [],
                inFocus: false
            }
        },

        watch: {
            stateQuery: 'updateQueryFromState'
        },

        components: {
            Loading
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
