<template>
    <div>
        <div :class="{'filter-name js-ht-filter': true, 'is-active': expanded}">
            <span class="filter-name__name">
                {{ filter.title }}
            </span>

            <svg class="filter-name__icon symbol-icon symbol-keyboard-down">
                <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
            </svg>
        </div>

        <div class="ht-container">
            <div class="ht-inner">
                <div :class="'filter-desc filter-desc--' + filter.id">
                    <template v-for="option in optionsToShow">
                        <catalog-filter-option
                            :key="option.id"
                            :id="option.id"
                            :title="option.title"
                            :count="option.productCount"
                            :checked="optionIsChecked(option.id)"
                            :disabled="optionIsDisabled(option.id)"
                            @click="optionClick(option.id)"
                        ></catalog-filter-option>
                    </template>

                    <template v-if="optionsTooMuch">
                        <template v-if="listIsOpened">
                            <div class="filter-more">
                                <span class="filter-more-link is-active" @click="closeList">
                                    <svg class="filter-more-link__icon">
                                        <use xlink:href="/assets/images/icons.svg#symbol-add"></use>
                                    </svg>

                                    <span class="filter-more-link__label">{{ $root.translate('Collapse') }}</span>
                                </span>
                            </div>
                        </template>

                        <template v-else>
                            <div class="filter-more">
                                <span class="filter-more-link" @click="openList">
                                    <svg class="filter-more-link__icon">
                                        <use xlink:href="/assets/images/icons.svg#symbol-add"></use>
                                    </svg>

                                    <span class="filter-more-link__label">{{ $root.translate('Show all') }}</span>
                                </span>
                            </div>
                        </template>

                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CatalogFilterOption from './CatalogFilterOption'
    import CatalogFilterMixin from './CatalogFilterMixin'

    export default {
        name: "CatalogFilter",

        components: {
            CatalogFilterOption
        },

        mixins: [
            CatalogFilterMixin
        ],

        data() {
            return {
                options: this.filter.options,
                listIsOpened: false
            }
        },

        props: {
            maxOptionsCount: {
                type: Number,
                default: 8
            }
        },

        methods: {
            onFilterChange() {
                this.options = this.filter.options
            },

            optionClick(optionId) {
                this.$store.dispatch('catalog/setFilterValue', [this.filter.id, optionId])
            },

            optionIsChecked(optionId) {
                return this.filter.checkedOptions.indexOf(optionId) !== -1
            },

            optionIsDisabled(optionId) {
                if (this.optionIsChecked(optionId)) {
                    return false
                }

                return this.filter.activeOptions.indexOf(optionId) === -1
            },

            openList() {
                this.listIsOpened = true
            },

            closeList() {
                this.listIsOpened = false
            },

            clear() {}
        },

        computed: {
            optionsLength() {
                return Object.keys(this.options).length
            },

            optionsTooMuch() {
                return this.optionsLength > this.maxOptionsCount && this.optionsLength - this.maxOptionsCount > 2
            },

            optionsToShow() {
                if (this.optionsTooMuch && !this.listIsOpened) {
                    return Object.keys(this.options).slice(0, this.maxOptionsCount).map(id => this.options[id])
                }
                else {
                    return this.options
                }
            }
        }
    }
</script>
