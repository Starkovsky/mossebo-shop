<template>
    <div class="reviews-list">
        <template v-for="review in reviews$">
            <review-item
                :key="'review-' + review.id"
                :review="review"
                @edit="edit(review)"
                @delete="remove(review)"
            ></review-item>
        </template>

        <button
            v-if="moreBtnIsVisible"
            class="catalog-more-btn block-ui js-more-btn"
            @click="showAll"
        >
            {{ $root.translate('Show all') }}
        </button>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import ReviewItem from './ReviewItem'
    import Rating from '../Rating'

    export default {
        name: 'ReviewsList',

        props: [
            'url',
            'title',
            'hideButton'
        ],

        components: {
            ReviewItem,
            Rating,
        },

        methods: {
            retry() {
                this.$store.dispatch('reviews/list/reFetch')
            },

            showAll() {
                this.$store.dispatch('reviews/list/all')
            },

            edit(review) {
                this.$emit('edit', review)
            },

            remove(review) {
                this.$store.dispatch('reviews/removeReview', review)
            },
        },

        computed: {
            ... mapState({
                reviews: state => state.reviews.list.reviews,
                all: state => state.reviews.list.all,

            }),

            reviews$() {
                if (this.all || this.reviews.length < 3) {
                    return this.reviews
                }
                else {
                    return this.reviews.slice(0, 2)
                }
            },

            moreBtnIsVisible() {
                return this.reviews$.length !== this.reviews.length
            },
        }
    }
</script>
