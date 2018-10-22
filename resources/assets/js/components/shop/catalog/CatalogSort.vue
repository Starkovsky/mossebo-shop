<template>
    <multi-select
        :options="options"
        :value="activeType"
        :max-height="300"
        :placeholder="$root.translate('Sort')"
        :searchable="false"
        :hide-selected="false"
        :multiple="false"
        :allow-empty="false"
        @select="setType"
    >
        <template slot="option" slot-scope="props">
            {{ props.option.title }}
        </template>

        <template slot="singleLabel" slot-scope="props">
            {{ props.option.title }}
        </template>
    </multi-select>
</template>

<script>
    import { mapState } from 'vuex'
    import MultiSelect from 'vue-multiselect'

    export default {
        name: 'catalog-sort',

        components: {
            MultiSelect
        },

        methods: {
            setType(type) {
                this.$store.dispatch('catalog/setSortType', type.value)
            },
        },

        computed: {
            ... mapState({
                types: state => state.catalog.sort.types,
                active: state => state.catalog.sort.active,
            }),

            options() {
                return Object.keys(this.types).reduce((acc, key) => {
                    acc.push({
                        title: this.types[key],
                        value: key
                    })

                    return acc
                }, [])
            },

            activeType() {
                return this.options.find(option => option.value === this.active)
            },
        }
    }
</script>
