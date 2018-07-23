<template>
    <div :class="classNameWithModificators('rating')">
        <div class="rating__stars">
            <div class="rating__icon"></div>
            <div class="rating__percent" :style="{width: getRatingPercent() + '%'}"></div>
        </div>

        <div v-if="!hideNum" class="rating__reviews-num">
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

        props: {
            rate: {
                default() {
                    return getRandomInt(30, 50) / 10
                }
            },

            num: {
                default() {
                    return getRandomInt(10, 50)
                }
            },

            hideNum: null
        },

        methods: {
            getRatingPercent() {
                return Math.ceil(this.rate / 5 * 100)
            },

            getScoresNum() {
                return this.num + ' ' + declOfNum(this.num, ['отзыв', 'отзыва', 'отзывов'])
            }
        }
    }
</script>


