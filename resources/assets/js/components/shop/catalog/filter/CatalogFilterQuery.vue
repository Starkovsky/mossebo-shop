<template>
    <div>
        <div :class="{'filter-name js-ht-filter': true, 'is-active': expanded}">
            <span class="filter-name__name">
                {{ $root.translate('filters.query') }}
            </span>

            <svg class="filter-name__icon symbol-icon symbol-keyboard-down">
                <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
            </svg>
        </div>

        <div class="ht-container">
            <div class="ht-inner">
                <div class="filter-desc">
                    <div class="form-group">
                        <input type="text" class="form-input" v-model="query" @input="inputChange" @keydown.enter="submit">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        name: 'CatalogFilterQuery',

        props: {
            expanded: {
                type: Boolean,
                default: true
            }
        },

        data() {
            return {
                query: ''
            }
        },

        mounted() {
            this.$nextTick(() => {
                heightToggle(this.$el.querySelector('.js-ht-filter'))
            })

            this.debouncer = _.debounce(() => {
                this.submit()
            }, 1000)

            this.query = this.stateQuery
        },

        methods: {

            inputChange(e) {
                this.debouncer(e.target.value)
            },

            submit() {
                this.$store.dispatch('catalog/setSearchQuery', this.query)
            },
        },

        computed: {
            ... mapState({
                stateQuery: state => state.catalog.search.query
            }),
        }
    }
</script>
