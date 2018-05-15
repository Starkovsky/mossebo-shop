<template>
    <div>
        <a class="filter-name"
           data-toggle="collapse"
           :href="'#filerCollapse' + id"
           role="button"
           :aria-expanded="expanded"
           :aria-controls="'filerCollapse' + id" >

            {{ title }}

            <svg class="symbol-icon symbol-keyboard-down">
                <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
            </svg>
        </a>

        <div class="collapse multi-collapse"
             :id="'filerCollapse' + id"
             :class="{show: expanded}" >

            <div class="filter-desc">
                <div v-for="option in orderedOptions" :key="option.id">
                    <catalog-filter-option
                        :title="option.title"
                        :checked="optionIsChecked(option.id)"
                        @click="optionClick(option.id)"/>
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
                checkedOptions: []
            }
        },

        methods: {
            optionClick(optionId) {
                let index = this.checkedOptions.indexOf(optionId)

                if (index === -1) {
                    this.checkedOptions.push(optionId)
                }
                else {
                    this.checkedOptions.splice(index, 1)
                }

                this.$root.$emit('filterChange')
            },

            optionIsChecked(optionId) {
                return this.checkedOptions.indexOf(optionId) !== -1
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

<style lang="scss" scoped>

    @import "../../../sass/variables/colors";

    .filter-name {
        display: block;
        position: relative;
        padding: 20px;
        color: $color-text-primary;

        &:hover {
            text-decoration: none;
            .symbol-icon {
                fill: $color-text-primary;
            }
        }

        .symbol-icon {
            float: right;
        }

        &[aria-expanded="false"] {
            .symbol-icon {
                transform: rotate(0deg);
            }
        }

        &[aria-expanded="true"] {
            .symbol-icon {
                transform: rotate(180deg);
            }
        }
    }

    .filter-desc {
        padding: 0 20px 8px;
    }
</style>
