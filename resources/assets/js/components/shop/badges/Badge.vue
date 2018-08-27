<template>
    <div
        class="badge"
        :style="{backgroundColor: color}"
        :title="title"
        data-toggle="tooltip"
        data-placement="top"
    >
        <div class="badge__content">
            <template v-if="icon">
                <svg class="badge__icon">
                    <use :xlink:href="'/vendor/images/badges.svg#' + icon"></use>
                </svg>
            </template>

            <template v-if="text">
                <div class="badge__text">
                    {{ text }}
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'badge',

        props: [
            'icon',
            'color',
            'title',
            'text'
        ],
    }
</script>
