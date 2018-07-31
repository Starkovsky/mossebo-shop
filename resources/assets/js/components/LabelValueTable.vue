<template>
    <div :class="classNameWithModificators('label-value-table')">
        <template v-for="item in data">
            <div v-if="isVisible(item)" class="label-value-table__item">
                <div class="label-value-table__label">
                    {{ item.label }}
                </div>

                <div :class="{'label-value-table__value': true, 'label-value-table__value--italic': item.italic}">
                    {{ getValue(item) }}
                </div>
            </div>
        </template>

    </div>
</template>

<script>
    import ClassNameWithModificators from '../mixins/ClassNameWithModificators'

    export default {
        name: "LabelValueTable",

        mixins: [
            ClassNameWithModificators
        ],

        props: {
            data: Array,
        },

        methods: {
            isVisible(item) {
                return !(_.isEmpty(item.value) && item.onEmpty === 'hide')
            },

            getValue(item) {
                if (_.isEmpty(item.value)) {
                    return this.$root.translate('unspecified')
                }

                return item.value
            }
        }
    }
</script>
