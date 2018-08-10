<template>
    <city-popup
        title="Укажите свой город"
        @close="close"
    >

        <div class="city-popup-search">
            <div class="form-group form-group--city-search">
                <label class="form-label" for="city-popup-search-input">
                    Введите название города:
                </label>

                <div class="input-group">

                    <div :class="{'search-input': true, 'is-opened': isOpened}">
                        <input
                            type="text"
                            class="search-input__input form-input"
                            id="city-popup-search-input"
                            :placeholder="$root.translate('Search')"
                            autocomplete="off"
                            :value="city ? city.name : query"
                            @input="input"
                            @keydown="keyDown"
                        >

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
                            <div class="search-result" v-if="results.length > 0">
                                <template v-for="(city, index) in results">
                                    <span
                                        :class="{'search-result__link': true, 'is-hovered': index === hovered}"
                                        @click="setCity(index)"
                                        @mouseover="setHover(index)"
                                        v-html="cityName(city)"
                                    ></span>
                                </template>
                            </div>
                        </div>
                    </div>

                    <button :class="{'button input-group-append': true, 'button-primary': !!city, 'button-light': !city}" :disabled="! city" @click="submitCity">
                        Ок
                    </button>

                </div>
            </div>
        </div>
    </city-popup>
</template>

<script>
    import { mapState } from 'vuex'
    import CityPopup from './CityPopup'
    import RequestMixin from '../../mixins/RequestMixin'
    import Core from '../../scripts/core'

    export default {
        name: 'CityPopupConfirm',

        mixins: [
            RequestMixin
        ],

        components: {
            CityPopup
        },

        props: [
            'close'
        ],

        data() {
            return {
                results: [],
                inFocus: false,
                hovered: 0,
                city: null
            }
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

            this.searchDebouncer = _.debounce(this.search, 300)

            window.addEventListener('click', this.clickHandler, {passive: true})
        },

        beforeDestroy() {
            window.removeEventListener('click', this.clickHandler)
        },

        methods: {
            setCity(index) {
                if (this.results.length && index in this.results) {
                    this.city = this.results[index]
                }
            },

            submitCity() {
                if (this.city) {
                    this.$store.dispatch('city/setCity', this.city)
                    this.close()
                    this.results = []
                    this.city = null
                }
            },

            input(e) {
                this.$store.dispatch('city/setQuery', e.target.value)
                this.city = null
                this.searchDebouncer()
            },

            keyDown(e) {
                let code = e.keyCode || e.which

                if (code === 38) {
                    e.preventDefault()
                    this.selectPrevCity()
                }

                if (code === 40) {
                    e.preventDefault()
                    this.selectNextCity()
                }

                if (code === 13) {
                    this.submitCity()
                }
            },

            selectPrevCity() {
                let index = this.hovered - 1

                if (index < 0) {
                    index = this.results.length - 1
                }

                this.setHover(index)
                this.setCity(this.hovered)
            },

            selectNextCity() {
                let index = this.hovered + 1

                if (this.results.length - 1 < index) {
                    index = 0
                }

                this.setHover(index)
                this.setCity(this.hovered)
            },

            setHover(index) {
                this.hovered = Math.max(0, index)
            },

            search() {
                if (this.query !== '') {
                    this.sendRequest('get', Core.apiUrl('location/search'), {
                        q: this.query
                    })
                        .success(response => {
                            this.results = response.data.cities
                            this.hovered = 0
                        })
                        .silent()
                }
            },

            cityName(city) {
                let name = [city.name]

                if (city.region) {
                    name.push(city.region)
                }

                name = name.join(', ')

                if (! this.query) {
                    return name
                }

                let lowerQuery = _.toLower(this.query)
                let lowerCity = _.toLower(name)

                let pos = -1
                let positions = []

                while ((pos = lowerCity.indexOf(lowerQuery, pos + 1)) != -1) {
                    positions.push(pos)
                }

                return positions.reverse().reduce((acc, position) => {
                    acc = acc.slice(0, position) + '<span>' + acc.slice(position, position + this.query.length) + '</span>' + acc.slice(position + this.query.length)

                    return acc
                }, name)
            }
        },

        computed: {
            isOpened() {
                return this.inFocus && this.results.length > 0
            },

            ... mapState({
                query: state => state.city.query
            })
        }
    }
</script>
