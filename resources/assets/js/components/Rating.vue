<template>
    <div :class="classNameWithModificators('rating')">
        <div class="rating__stars">
            <svg class="rating__icon" viewBox="0 0 120 28">
                <use xlink:href="/assets/images/icons.svg#product-rating"></use>
            </svg>
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


