<template>
    <div :class="classNameWithModificators('rating', num ? null : 'empty')">
        <div class="rating__stars">
            <div class="rating__icon">
                <div class="rating__percent" :style="{width: getRatingPercent() + '%'}"></div>
            </div>
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
                    return 0
                }
            },

            num: {
                default() {
                    return 0
                }
            },

            hideNum: null
        },

        methods: {
            getRatingPercent() {
                return Math.ceil(this.rate / 5 * 100)
            },

            getScoresNum() {
                if (this.num > 0) {
                    return this.num + ' ' + declOfNum(this.num, ['отзыв', 'отзыва', 'отзывов'])
                }

                return 'Нет отзывов'
            }
        },
    }
</script>


