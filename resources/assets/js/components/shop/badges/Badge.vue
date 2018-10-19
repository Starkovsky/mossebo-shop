<template>
    <div
        :class="classNameWithModificators('badge', iconModif)"
        :style="{backgroundColor: color}"
        :title="title"
        :data-toggle="title && !noTooltip ? 'tooltip' : false"
        :data-placement="title && !noTooltip ? 'top' : false"
    >
        <template v-if="icon">
            <svg class="badge__icon">
                <use :xlink:href="'/vendor/images/badges.svg#' + icon"></use>
            </svg>
        </template>

        <template v-if="text">
            <div class="badge__text" v-html="text"></div>
        </template>
    </div>
</template>

<script>
    import ClassNameWithModificators from '../../../mixins/ClassNameWithModificators'

    export default {
        name: 'badge',

        props: [
            'icon',
            'color',
            'title',
            'text',
            'no-tooltip',
        ],

        mixins: [
            ClassNameWithModificators
        ],

        computed: {
            iconModif() {
                if (this.icon) {
                    return this.icon.replace('symbol-', '')
                }

                return undefined
            }
        }
    }
</script>
