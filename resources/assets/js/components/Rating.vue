<template>
    <div :class="classNameWithModificators('rating')">
        <div class="rating__stars">
            <div class="rating__icon"></div>
            <div class="rating__percent" :style="{width: getRatingPercent() + '%'}"></div>
        </div>

        <div class="rating__reviews-num">
            {{ getScoresNum() }}
        </div>
    </div>
</template>

<script>
    import ClassNameWithModificators from '../mixins/ClassNameWithModificators'
    export default {
        name: "Rating",

        mixins: [
            ClassNameWithModificators
        ],

        methods: {
            getRatingPercent() {
                return getRandomInt(70, 100)
            },

            getScoresNum() {
                let value = getRandomInt(1, 10)
                return value + ' ' + declOfNum(value, ['отзыв', 'отзыва', 'отзывов'])
            }
        }
    }
</script>


