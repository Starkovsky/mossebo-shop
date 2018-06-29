<template>
    <div>
        <div :class="{'filter-name js-ht-filter': true, 'is-active': expanded}">
            <span class="filter-name__name">
                {{ title }}
            </span>

            <svg class="filter-name__icon symbol-icon symbol-keyboard-down">
                <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
            </svg>
        </div>

        <div class="ht-container">
            <div class="ht-inner">
                <div :class="'filter-desc filter-desc--' + id">
                    <template v-for="option in orderedOptions">
                        <catalog-filter-option
                            :id="option.id"
                            :key="option.id"
                            :title="option.title"
                            :checked="optionIsChecked(option.id)"
                            :disabled="optionIsDisabled(option.id)"
                            @click="optionClick(option.id)"
                        ></catalog-filter-option>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CatalogFilterOption from './CatalogFilterOption'

    export default {
        name: "CatalogFilter",

        components: {
            CatalogFilterOption
        },

        props: {
            id: Number,
            title: String,
            options: Array,
            expanded: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                checkedOptions: [],
                activeOptions: [],
                activeOptions$: {}
            }
        },

        mounted() {
            this.$nextTick(() => {
                heightToggle('.js-ht-filter')
            })
        },

        methods: {
            optionClick(optionId) {
                if (this.checkedOptions.indexOf(optionId) === -1) {
                    this.checkedOptions = [
                        ... this.checkedOptions,
                        optionId
                    ]

                }
                else {
                    this.checkedOptions = this.checkedOptions.filter(id => id != optionId)
                }

                this.$root.$emit('filterChanged')
            },

            optionIsChecked(optionId) {
                return this.checkedOptions.indexOf(optionId) !== -1
            },

            optionIsDisabled(optionId) {
                if (this.optionIsChecked(optionId)) {
                    return false
                }

                return this.activeOptions.indexOf(optionId) === -1
            },

            prepareActiveOptions({options = []}) {
                options.forEach(optionId => {
                    this.activeOptions$[optionId] = 1
                })
            },

            applyActiveOptions() {
                this.activeOptions = Object.keys(this.activeOptions$).map(optionId => parseInt(optionId))
                this.activeOptions$ = {}
            },

            checkProduct(product = {}) {
                if (this.checkedOptions.length === 0) {
                    return true
                }

                let options = product.options

                if (! (options instanceof Array && options.length > 0)) {
                    return false;
                }

                for (let i = 0; i < this.checkedOptions.length; i++) {
                    let index = options.indexOf(this.checkedOptions[i]);

                    if (index !== -1) {
                        return true;
                    }
                }

                return false;
            },

            isDirty() {
                return !!this.checkedOptions.length
            },

            clear() {
                this.checkedOptions = []
            }
        },

        computed: {
            orderedOptions() {
                return _.orderBy(this.options, 'position')
            }
        },
    }
</script>
