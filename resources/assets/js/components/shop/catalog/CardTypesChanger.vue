<template>
    <div class="card-types-changer">
        <template v-for="(data, type) in types">
            <div
                :key="type"
                :class="{'card-types-changer__item': true, 'is-active': active === type}"
                data-toggle="tooltip"
                data-placement="top"
                :title="data.title"
                @click="click(type)"
            >
                <svg class="card-types-changer__icon">
                    <use :xlink:href="'/assets/images/icons.svg#' + data.icon"></use>
                </svg>
            </div>
        </template>

    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        name: "CardTypesChanger",

        mounted() {
            this.$root.initTooltips()
        },

        methods: {
            click(type) {
                this.$store.dispatch('catalog/setCardType', type)
            }
        },

        computed: {
            ... mapState({
                types: state => state.catalog.cards.types,
                active: state => state.catalog.cards.active
            }),
        }
    }
</script>
